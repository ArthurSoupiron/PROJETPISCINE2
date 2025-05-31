<?php
// general/index.php
$pageTitle = 'Sportify : Accueil';
include('header.php');
?>

<main>
  <!-- BANNIÈRE PRINCIPALE -->
  <section class="banner">
    <div class="container" style="flex-direction:column;">
      <h2>Votre sport, votre coach, votre créneau, en 3 clics</h2>
      <p>Découvrez des dizaines de spécialistes, réservez un créneau et bénéficiez d’un suivi personnalisé.</p>
    </div>
  </section>

    <!-- ÉVÉNEMENT DE LA SEMAINE -->
    <div class="container" style="flex-direction:column; margin-top:2rem;">
      <h2 style="font-size:1.75rem; color:#2d3748; margin-bottom:1rem;">Événement de la semaine</h2>
      <div class="carousel" style="display:flex; overflow-x:auto; gap:1rem; padding-bottom:1rem;">
        <div class="event-card" style="background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.1); overflow:hidden;">
          <img src="../images/porte_ouverte.jpg" alt="Match" style="width:100%; height:250px; object-fit:cover;">
          <div class="info" style="padding:1rem;">
            <h3 style="margin-bottom:.5rem; color:#2d3748;">Match Omnes vs Visiteurs</h3>
            <p style="color:#555;">Mercredi 11 juin – Rugby collégial ouvert au public et buvette.</p>
          </div>
        </div>

    <!-- NOS SPÉCIALISTES -->
    <div class="container" style="flex-direction:column; margin:2rem auto;">
      <h2 style="font-size:1.75rem; color:#2d3748; margin-bottom:1rem;">Nos spécialistes</h2>
      <div class="carousel" style="display:flex; overflow-x:auto; gap:1rem; padding-bottom:1rem;">
        <!-- Coach Marie -->
        <div class="coach-card" style="flex:0 0 200px; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.1); text-align:center;">
          <img src="../images/porte_ouverte.jpg" alt="Coach Marie" style="width:100%; height:150px; object-fit:cover; border-radius:4px 4px 0 0;">
          <h4 style="margin:.75rem 0 .25rem; color:#2d3748;">Coach Marie</h4>
          <p style="padding:0 .5rem 1rem; color:#555;">Nutrition & Fitness</p>
        </div>
        
    <!-- SECTION CARTE GOOGLE MAP -->
    <section class="map-section" style="
      background: #fff;
      padding: 3rem 1rem;
      text-align: center;
    ">
      <h2 style="
        font-size: 1.75rem;
        color: #2d3748;
        margin-bottom: 1.5rem;
      ">
        Notre emplacement
      </h2>
      <div style="
        max-width: 1000px;
        width: 100%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      ">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9999999999995!2d2.297643315674123!3d48.87378197928833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc0e0bd1234%3A0xabcdef1234567890!2s60%20Rue%20Fran%C3%A7ois%20Ier%2C%2075008%20Paris!5e0!3m2!1sfr!2sfr!4v1629999999999!5m2!1sfr!2sfr"
          width="100%" height="500" style="border:0;"
          allowfullscreen loading="lazy"
        ></iframe>
      </div>
    </section>
  </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>