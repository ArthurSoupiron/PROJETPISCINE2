<?php
// general/toutparcourir.php
$pageTitle = 'Sportify : Tout Parcourir';
include('header.php');
?>

<style>
/* === STYLES SPÉCIFIQUES À toutparcourir.php === */
.browse {
  padding: 40px 0;
}

.section-title {
  font-size: 28px;
  margin-bottom: 30px;
  text-align: center;
  color: #0057a0;
}

/* Onglets */
.browse-nav ul {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 30px;
  list-style: none;
  padding: 0;
}

.browse-nav .tab-btn {
  padding: 10px 20px;
  border: none;
  background-color: #e0e0e0;
  color: #333;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.browse-nav .tab-btn.active,
.browse-nav .tab-btn:hover {
  background-color: #0057a0;
  color: #fff;
}

/* Contenu des onglets */
.tab-content {
  display: none;
}

.tab-content.active {
  display: block;
}

/* Grille de cartes */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

/* Cartes */
.card {
  background-color: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.card h3 {
  color: #0057a0;
  margin-bottom: 10px;
}

.card p,
.card ul {
  margin: 0;
  font-size: 14px;
  color: #555;
}

.card.full {
  grid-column: span 2;
  background-color: #f9f9f9;
}

/* Liens */
.card a {
  color: #0057a0;
  font-weight: bold;
  text-decoration: none;
}

.card a:hover {
  text-decoration: underline;
}
</style>

<main>
  <section class="browse">
    <div class="container">
      <h2 class="section-title">Tout Parcourir</h2>

      <!-- NAVIGATION PAR ONGLET -->
      <nav class="browse-nav">
        <ul>
          <li><button class="tab-btn active" data-target="activites">Activités sportives</button></li>
          <li><button class="tab-btn" data-target="competition">Sports de compétition</button></li>
          <li><button class="tab-btn" data-target="salle">Salle de sport Omnes</button></li>
        </ul>
      </nav>
    </div>

    <div class="container">
      <!-- 1. ACTIVITÉS SPORTIVES -->
      <div id="activites" class="tab-content active">
        <div class="grid">
          <?php 
          $acts = ['Musculation','Fitness','Biking','Cardio-Training','Cours Collectifs'];
          foreach($acts as $act): ?>
            <div class="card">
              <h3><?= htmlspecialchars($act) ?></h3>
              <p>
                Coach responsable &middot;
                <a href="detail_coach.php?type=activites&name=<?= urlencode($act) ?>">
                  Voir le coach →
                </a>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 2. SPORTS DE COMPÉTITION -->
      <div id="competition" class="tab-content">
        <div class="grid">
          <?php 
          $sports = ['Basketball','Football','Rugby','Tennis','Natation','Plongeon'];
          foreach($sports as $sport): ?>
            <div class="card">
              <h3><?= htmlspecialchars($sport) ?></h3>
              <p>
                Coach compétitif &middot;
                <a href="detail_coach.php?type=competition&name=<?= urlencode($sport) ?>">
                  Voir le coach →
                </a>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 3. SALLE DE SPORT OMNES -->
      <div id="salle" class="tab-content">
        <div class="grid">
          <div class="card full">
            <h3>Règles & Horaires</h3>
            <ul>
              <li>Utilisation des machines</li>
              <li>Horaires d’ouverture</li>
              <li>Questionnaire nouvel utilisateur</li>
            </ul>
          </div>
          <div class="card">
            <h3>Responsables</h3>
            <p>
              <strong>Mr Jean Dupont</strong><br>
              Bureau : Bât. A, Rdc<br>
              Tél : 01 23 45 67 89
            </p>
          </div>
          <div class="card">
            <h3>Prendre un RDV</h3>
            <p><a href="rdv_salle.php">→ Réserver une visite</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include('footer.php'); ?>

<script>
  // Basculer d'un onglet à l'autre
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById(btn.dataset.target).classList.add('active');
    });
  });
</script>
