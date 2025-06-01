<?php
// detail_coach.php
$pageTitle = 'Sportify : Coach';
include('header.php');
require_once('db.php');


// Sécurité des paramètres GET
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';

// Coachs d'activités sportives
$coachs_activites = [
  'Musculation' => [
    'nom' => 'Alex Durand',
    'photo' => 'images/coach_muscu.jpg',
    'bureau' => 'Bâtiment B - Salle 3',
    'cv' => 'cv/alex_durand.pdf',
    'dispo_img' => 'images/calendrier_muscu.png',
    'telephone' => '+33 7 89 65 14 25',
    'email' => 'alex_durand@sportify.com'
  ],
  'Fitness' => [
    'nom' => 'Sophie Martin',
    'photo' => 'images/coach_fitness.jpeg',
    'bureau' => 'Bâtiment A - Salle 5',
    'cv' => 'cv/sophie_martin.pdf',
    'dispo_img' => 'images/calendrier_fitness.png',
    'telephone' => '+33 6 59 34 14 12',
    'email' => 'sophie_martin@sportify.com'
  ],
  'Biking' => [
    'nom' => 'Julien Rousseau',
    'photo' => 'images/coach_biking.png',
    'bureau' => 'Bâtiment C - Studio 1',
    'cv' => 'cv/julien_rousseau.pdf',
    'dispo_img' => 'images/calendrier_biking.png',
    'telephone' => '+33 7 65 47 28 34',
    'email' => 'julien_rousseau@sportify.com'
  ],
  'Cardio-Training' => [
    'nom' => 'Claire Bernard',
    'photo' => 'images/coach_cardio.jpg',
    'bureau' => 'Salle Cardio',
    'cv' => 'cv/claire_bernard.pdf',
    'dispo_img' => 'images/calendrier_cardio.png',
    'telephone' => '+33 3 46 72 95 18',
    'email' => 'claire_bernard@sportify.com'
  ],
  'Cours Collectifs' => [
    'nom' => 'David Lefevre',
    'photo' => 'images/coach_cours_collectif.jpg',
    'bureau' => 'Salle Polyvalente',
    'cv' => 'cv/david_lefevre.pdf',
    'dispo_img' => 'images/calendrier_collectif.png',
    'telephone' => '+33 7 64 25 18 37',
    'email' => 'david_lefevre@sportify.com'
  ]
];

// Coachs de compétition
$coachs_competition = [
  'Basketball' => [
    'nom' => 'Emma Lopez',
    'photo' => 'images/coach_basket.jpg',
    'bureau' => 'Bâtiment D - Bureau 12',
    'cv' => 'cv/emma_lopez.pdf',
    'dispo_img' => 'images/calendrier_basket.png',
    'telephone' => '+33 7 88 55 44 11',
    'email' => 'emma_lopez@sportify.com'
  ],
  'Football' => [
    'nom' => 'Lucas Moreau',
    'photo' => 'images/coach_football.jpg',
    'bureau' => 'Bâtiment E - Bureau 7',
    'cv' => 'cv/lucas_moreau.pdf',
    'dispo_img' => 'images/calendrier_football.png',
    'telephone' => '+33 6 77 88 99 00',
    'email' => 'lucas_moreau@sportify.com'
  ],
  'Rugby' => [
    'nom' => 'Chloé Dubois',
    'photo' => 'images/coach_rugby.jpg',
    'bureau' => 'Bâtiment A - Terrain',
    'cv' => 'cv/chloe_dubois.pdf',
    'dispo_img' => 'images/calendrier_rugby.png',
    'telephone' => '+33 6 55 44 33 22',
    'email' => 'chloe_dubois@sportify.com'
  ],
  'Tennis' => [
    'nom' => 'Thomas Petit',
    'photo' => 'images/coach_tennis.jpg',
    'bureau' => 'Centre Sportif - Court 1',
    'cv' => 'cv/thomas_petit.pdf',
    'dispo_img' => 'images/calendrier_tennis.png',
    'telephone' => '+33 6 00 11 22 33',
    'email' => 'thomas_petit@sportify.com'
  ],
  'Natation' => [
    'nom' => 'Camille Leroy',
    'photo' => 'images/coach_natation.jpg',
    'bureau' => 'Piscine - Cabine 2',
    'cv' => 'cv/camille_leroy.pdf',
    'dispo_img' => 'images/calendrier_natation.png',
    'telephone' => '+33 6 44 33 22 11',
    'email' => 'camille_leroy@sportify.com'
  ],
  'Plongeon' => [
    'nom' => 'Maxime Garnier',
    'photo' => 'images/coach_plongeon.jpg',
    'bureau' => 'Piscine - Hauteur',
    'cv' => 'cv/maxime_garnier.pdf',
    'dispo_img' => 'images/calendrier_plongeon.png',
    'telephone' => '+33 7 33 22 11 00',
    'email' => 'maxime_garnier@sportify.com'
  ]
];

// Sélection des bons coachs
$coachs = ($type === 'competition') ? $coachs_competition : $coachs_activites;

$coach = $coachs[$name] ?? null;
$disponibilites_creneaux = [];

if ($coach) {
    // Récupérer l'ID du coach via son email
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->execute([$coach['email']]);
  $row = $stmt->fetch();

  if ($row) {
    $coach_id = $row['id'];

        // Récupérer les créneaux de disponibilité
    $stmt = $pdo->prepare("SELECT jour_semaine, heure_debut FROM disponibilites WHERE specialiste_id = ? ORDER BY FIELD(jour_semaine, 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'), heure_debut");
    $stmt->execute([$coach_id]);
    $dispos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dispos as $d) {
      $disponibilites_creneaux[$coach['nom']][] = $d['jour_semaine'] . ' à ' . $d['heure_debut'];
    }
  }
}

?>

<main class="coach-profile">
  <div class="container">
    <?php if ($coach): ?>
      <h2><?= $coach['nom'] ?> - Coach <?= $name ?></h2>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'coach' && $_SESSION['nom'] === $coach['nom']): ?>
        <h3>Ajouter une disponibilité</h3>
        <form method="POST">
          <label for="jour">Jour :</label>
          <select name="jour" id="jour" required>
            <?php foreach (['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'] as $jour): ?>
              <option value="<?= $jour ?>"><?= $jour ?></option>
            <?php endforeach; ?>
          </select>

          <label for="heure">Heure :</label>
          <input type="time" name="heure" id="heure" required>

          <button type="submit" name="ajouter_dispo" class="btn">Ajouter</button>
        </form>
      <?php endif; ?>

      <div class="coach-details">
        <img src="<?= $coach['photo'] ?>" alt="Photo de <?= $coach['nom'] ?>" class="coach-photo">
        <div class="coach-info">
          <p><strong>Bureau :</strong> <?= $coach['bureau'] ?></p>
          <p><strong>Télephone :</strong> <?= $coach['telephone'] ?></p>
          <p><strong>Email :</strong> <?= $coach['email'] ?></p>

          <p><strong>CV :</strong> <a href="cv.php?coach=<?= urlencode($coach['nom']) ?>" class="btn-mini" target="_blank">Voir son CV</a></p>
          <p><strong>Disponibilités :</strong></p>
          <?php
$nomCoach = strtolower(str_replace(' ', '_', $coach['nom'])); // ex: alex_durand
$cvPath = "cv/CV_{$nomCoach}.xml";

if (file_exists($cvPath)) {
  $xml = simplexml_load_file($cvPath);
  if ($xml && isset($xml->disponibilites->jour)) {
    echo "<table class='dispo-table'>";
    echo "<thead><tr><th>Jour</th><th>Créneaux</th><th>Action</th></tr></thead><tbody>";

    foreach ($xml->disponibilites->jour as $jour) {
      $nomJour = ucfirst((string)$jour['nom']);
      $creneaux = [];

      foreach ($jour->creneau as $creneau) {
        $debut = (string)$creneau['debut'];
        $fin = (string)$creneau['fin'];
        $horaire = "$debut à $fin";
        $creneaux[] = $horaire;
      }

      $creneauxText = implode('<br>', $creneaux);
      $reservationLink = "<a href='prendre_rdv.php?coach=" . urlencode($coach['nom']) . "&jour=" . urlencode($nomJour) . "' class='btn-mini'>Réserver</a>";

      echo "<tr><td>$nomJour</td><td>$creneauxText</td><td>$reservationLink</td></tr>";
    }

    echo "</tbody></table>";
  } else {
    echo "<p class='no-dispo'> Aucune disponibilité trouvée dans le fichier XML.</p>";
  }
} else {
  echo "<p class='no-dispo'> Fichier XML introuvable pour ce coach.</p>";
}
?>




<div class="actions">
  <br>
  <a href="message.php?coach=<?= urlencode($coach['nom']) ?>" class="btn">Contacter</a>
</div>
</div>
</div>
<?php else: ?>
  <p>Coach introuvable.</p>
<?php endif; ?>
</div>
</main>

<style>
  .coach-profile {
    padding: 40px 0;
  }
  .coach-details {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    margin-top: 20px;
  }
  .coach-photo {
    max-width: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .coach-info {
    flex: 1;
    min-width: 250px;
  }
  .coach-info p {
    font-size: 16px;
    margin-bottom: 10px;
  }
  .actions .btn {
    display: inline-block;
    background-color: #0057a0;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin-right: 10px;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }
  .actions .btn:hover {
    background-color: #004080;
  }
</style>

<style>
  .dispo-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }

  .dispo-table th, .dispo-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 15px;
  }

  .dispo-table th {
    background-color: #0057a0;
    color: white;
  }

  .dispo-table td a.btn-mini {
    display: inline-block;
    background-color: #007BFF;
    color: white;
    padding: 5px 12px;
    font-size: 13px;
    border-radius: 5px;
    text-decoration: none;
  }

  .dispo-table td a.btn-mini:hover {
    background-color: #0056b3;
  }
</style>


<?php include('footer.php'); ?>
