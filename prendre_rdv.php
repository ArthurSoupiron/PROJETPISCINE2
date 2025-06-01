<?php
session_start();
require_once 'db.php';
$pageTitle = 'Sportify : Prendre un Rendez-vous';

// Détection si requête AJAX (POST pour RDV)
$isAjax = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jour'], $_POST['heure'], $_POST['coach_id']));

if ($isAjax) {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
        echo json_encode(['success' => false, 'message' => 'Vous devez être connecté comme client pour réserver un rendez-vous.']);
        exit;
    }

    $client_id = $_SESSION['user']['id'];
    $jour = $_POST['jour'];
    $heure = $_POST['heure'];
    $coach_id = $_POST['coach_id'];

    $jour_map = ['Lundi'=>1,'Mardi'=>2,'Mercredi'=>3,'Jeudi'=>4,'Vendredi'=>5,'Samedi'=>6,'Dimanche'=>7];
    $today = new DateTime();
    $target = $jour_map[$jour];
    $days_to_add = ($target - $today->format('N') + 7) % 7;
    if ($days_to_add === 0) $days_to_add = 7;
    $date_rdv = $today->modify("+$days_to_add days")->format('Y-m-d');

    $stmt = $pdo->prepare("SELECT * FROM rendezvous WHERE specialiste_id = :coach_id AND date_rdv = :date_rdv AND heure_rdv = :heure AND statut = 'confirmé'");
    $stmt->execute([
        'coach_id' => $coach_id,
        'date_rdv' => $date_rdv,
        'heure' => $heure
    ]);

    if ($stmt->rowCount() === 0) {
        $insert = $pdo->prepare("INSERT INTO rendezvous (client_id, specialiste_id, date_rdv, heure_rdv, statut) VALUES (:client_id, :coach_id, :date_rdv, :heure, 'confirmé')");
        $insert->execute([
            'client_id' => $client_id,
            'coach_id' => $coach_id,
            'date_rdv' => $date_rdv,
            'heure' => $heure
        ]);
        echo json_encode(['success' => true, 'message' => "Rendez-vous confirmé avec le coach #$coach_id pour $jour à $heure"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ce créneau est déjà réservé.']);
    }
    exit;
}

// Affichage HTML
include('header.php');

// Accès refusé si client non connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    echo "<p>Vous devez être connecté comme client pour réserver un rendez-vous.</p>";
    include('footer.php');
    exit;
}

// Préparation données coachs
$coachData = [];
$jours_ordre = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

foreach (glob("cv/CV_*.xml") as $file) {
    $xml = simplexml_load_file($file);
    $id = (int)$xml->coach->id;
    $nom = (string)$xml->coach->nom;
    $prenom = (string)$xml->coach->prenom;
    $specialite = (string)$xml->coach->specialite;

    $dispos = [];
    foreach ($xml->disponibilites->jour as $jour) {
        $nom_jour = ucfirst((string)$jour['nom']);
        if (!in_array(strtolower($nom_jour), $jours_ordre)) continue;

        foreach ($jour->creneau as $creneau) {
            $start = new DateTime((string)$creneau['debut']);
            $end = new DateTime((string)$creneau['fin']);
            while ($start < $end) {
                $dispos[$nom_jour][] = $start->format('H:i');
                $start->modify('+1 hour');
            }
        }
    }

    $today = new DateTime();
    $end = (clone $today)->modify('+7 days');
    $stmt = $pdo->prepare("SELECT date_rdv, heure_rdv FROM rendezvous WHERE specialiste_id = :coach_id AND statut = 'confirmé' AND date_rdv BETWEEN :start AND :end");
    $stmt->execute([
        'coach_id' => $id,
        'start' => $today->format('Y-m-d'),
        'end' => $end->format('Y-m-d')
    ]);
    $rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reserves = [];
    foreach ($rdvs as $rdv) {
        $d = new DateTime($rdv['date_rdv']);
        $j = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'][$d->format('N') - 1];
        $reserves[$j][] = $rdv['heure_rdv'];
    }

    $coachData[] = [
        'id' => $id,
        'nom' => "$prenom $nom",
        'specialite' => $specialite,
        'disponibilites' => $dispos,
        'reserves' => $reserves
    ];
}
?>

<style>
.rdv-table { width: 100%; border-collapse: collapse; margin: 30px 0; text-align: center; }
.rdv-table th, .rdv-table td { padding: 12px; border: 1px solid #ccc; }
.rdv-available { background-color: white; cursor: pointer; }
.rdv-reserved { background-color: #007bff; color: white; cursor: default; }
.rdv-unavailable {
  background: repeating-linear-gradient(45deg, #f0f0f0, #f0f0f0 5px, #d0d0d0 5px, #d0d0d0 10px);
  cursor: not-allowed;
}
.rdv-available:hover { background-color: #e0f0ff; }
#confirmationMessage { margin-top: 20px; font-weight: bold; color: green; }
</style>

<main class="rdv-page">
  <section class="container">
    <h2>Disponibilités des Coachs</h2>
    <p>Choisissez un créneau disponible (blanc) pour réserver. Les créneaux pris sont en bleu.</p>

    <?php foreach ($coachData as $coach): ?>
      <h3><?= htmlspecialchars($coach['nom']) ?></h3>
      <p><strong>Spécialité :</strong> <?= htmlspecialchars($coach['specialite']) ?></p>

      <table class="rdv-table">
        <thead>
          <tr>
            <th>Heure</th>
            <?php foreach ($jours_ordre as $jour): ?>
              <th><?= ucfirst($jour) ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $all_hours = array_unique(array_merge(...array_values($coach['disponibilites'])));
          sort($all_hours);

          foreach ($all_hours as $heure) {
              echo "<tr><td>$heure</td>";
              foreach ($jours_ordre as $jour_base) {
                  $jour = ucfirst($jour_base);
                  $dispo = isset($coach['disponibilites'][$jour]) && in_array($heure, $coach['disponibilites'][$jour]);
                  $reserved = isset($coach['reserves'][$jour]) && in_array($heure, $coach['reserves'][$jour]);
                  if ($dispo && !$reserved) {
                      echo "<td class='rdv-available' data-jour='$jour' data-heure='$heure' data-coach-id='{$coach['id']}'>$heure</td>";
                  } elseif ($dispo && $reserved) {
                      echo "<td class='rdv-reserved'>$heure</td>";
                  } else {
                      echo "<td class='rdv-unavailable'></td>";
                  }
              }
              echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    <?php endforeach; ?>

    <div id="confirmationMessage"></div>
  </section>
</main>

<script>
document.querySelectorAll('.rdv-available').forEach(cell => {
  cell.addEventListener('click', async () => {
    const jour = cell.getAttribute('data-jour');
    const heure = cell.getAttribute('data-heure');
    const coach_id = cell.getAttribute('data-coach-id');

    try {
      const res = await fetch('', {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `jour=${encodeURIComponent(jour)}&heure=${encodeURIComponent(heure)}&coach_id=${coach_id}`
      });

      if (!res.ok) throw new Error("Erreur serveur");

      const data = await res.json();
      const msgBox = document.getElementById('confirmationMessage');
      msgBox.textContent = data.message;
      msgBox.style.color = data.success ? 'green' : 'red';

      if (data.success) {
        cell.classList.remove('rdv-available');
        cell.classList.add('rdv-reserved');
        cell.textContent = heure;
        cell.removeAttribute('data-jour');
        cell.removeAttribute('data-heure');
        cell.removeAttribute('data-coach-id');
      } else {
        alert(data.message);
      }
    } catch (error) {
      alert("Une erreur est survenue. Merci de réessayer.");
    }
  });
});
</script>

<?php include('footer.php'); ?>
