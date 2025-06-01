<?php
// detail_coach.php
$pageTitle = 'Sportify : Coach';
include('header.php');

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
?>

<main class="coach-profile">
  <div class="container">
    <?php if ($coach): ?>
      <h2><?= $coach['nom'] ?> - Coach <?= $name ?></h2>
      <div class="coach-details">
        <img src="<?= $coach['photo'] ?>" alt="Photo de <?= $coach['nom'] ?>" class="coach-photo">
        <div class="coach-info">
          <p><strong>Bureau :</strong> <?= $coach['bureau'] ?></p>
          <p><strong>Télephone :</strong> <?= $coach['telephone'] ?></p>
          <p><strong>Email :</strong> <?= $coach['email'] ?></p>
          <p><strong>CV :</strong> <a href="<?= $coach['cv'] ?>" target="_blank">Voir son CV</a></p>
          <p><strong>Disponibilités :</strong></p>
          <img src="<?= $coach['dispo_img'] ?>" alt="Calendrier de disponibilités">
          <div class="actions">
            <a href="prendre_rdv.php?coach=<?= urlencode($coach['nom']) ?>" class="btn">Prendre un RDV</a>
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

<?php include('footer.php'); ?>
