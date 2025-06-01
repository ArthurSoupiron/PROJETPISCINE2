<?php
session_start();
require_once 'db.php';
$pageTitle = 'Sportify : Mes Rendez-vous';
include('header.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    echo "<p>Vous devez être connecté comme client pour voir vos rendez-vous.</p>";
    include('footer.php');
    exit;
}

$client_id = $_SESSION['user']['id'];

// Annulation d'un RDV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['annuler_id'])) {
    $rdv_id = (int) $_POST['annuler_id'];

    // Vérification que le RDV appartient bien au client
    $checkStmt = $pdo->prepare("SELECT id FROM rendezvous WHERE id = :id AND client_id = :client_id AND statut = 'confirmé'");
    $checkStmt->execute(['id' => $rdv_id, 'client_id' => $client_id]);

    if ($checkStmt->rowCount() > 0) {
        $annulStmt = $pdo->prepare("UPDATE rendezvous SET statut = 'annulé' WHERE id = :id");
        $annulStmt->execute(['id' => $rdv_id]);
        echo "<p class='success'> Rendez-vous annulé avec succès.</p>";
    } else {
        echo "<p class='error'> Impossible d'annuler ce rendez-vous.</p>";
    }
}

// Récupération des RDVs confirmés
$stmt = $pdo->prepare("
    SELECT r.id, r.date_rdv, r.heure_rdv, u.nom, u.prenom, u.id AS coach_id
    FROM rendezvous r
    JOIN users u ON r.specialiste_id = u.id
    WHERE r.client_id = :client_id AND r.statut = 'confirmé'
    ORDER BY r.date_rdv ASC, r.heure_rdv ASC
");
$stmt->execute(['client_id' => $client_id]);
$rdvs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container">
  <h2>Mes Rendez-vous Confirmés</h2>

  <?php if (!empty($rdvs)): ?>
    <ul>
      <?php foreach ($rdvs as $rdv): ?>
        <?php
          $date = new DateTime($rdv['date_rdv']);
          $jour = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'][$date->format('w')];
          $heure = substr($rdv['heure_rdv'], 0, 5);
          $coachNom = htmlspecialchars($rdv['prenom'] . ' ' . $rdv['nom']);

          // Chargement de la spécialité via fichier XML
          $prenom_fichier = strtolower($rdv['prenom']);
          $nom_fichier = strtolower($rdv['nom']);
          $xmlPath = "cv/CV_{$prenom_fichier}_{$nom_fichier}.xml";
          $specialite = 'Spécialité non renseignée';

          if (file_exists($xmlPath)) {
              $xml = simplexml_load_file($xmlPath);
              if ($xml && isset($xml->coach->specialite)) {
                  $specialite = 'Spécialité : ' . htmlspecialchars((string)$xml->coach->specialite);
              }
          }
        ?>
        <li>
          <strong><?= $jour ?> <?= $date->format('d/m/Y') ?></strong> à <strong><?= $heure ?></strong><br>
          Coach : <strong><?= $coachNom ?></strong><br>
          <?= $specialite ?><br>
          <form method="post" onsubmit="return confirm('Confirmer l’annulation de ce rendez-vous ?');" style="margin-top:5px;">
            <input type="hidden" name="annuler_id" value="<?= $rdv['id'] ?>">
            <button type="submit">Annuler</button>
          </form>
        </li>
        <hr>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>Vous n’avez encore réservé aucun créneau.</p>
  <?php endif; ?>

  <a href="prendre_rdv.php" class="btn">Réserver un autre RDV</a>
</main>

<?php include('footer.php'); ?>
