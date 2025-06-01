<?php
$pageTitle = 'Sportify : Accueil';
include('header.php');
?>

<section class="section-accueil">
  <div class="colonne">
    <h3>Événement de la semaine</h3>
    <div class="event-card">
      <img src="images/affiche.png" alt="Match">
      <div class="info">
        <h4>Match Omnes vs Visiteurs</h4>
        <p>Samedi 7 juin – Handball ECE VS ESILV.</p>
      </div>
    </div>
  </div>

  <div class="colonne">
    <h3>Nos spécialistes</h3>
    <div class="coach-card">
      <img src="images/coach.jpeg" alt="Coach Marie">
      <h4>Coach Marie</h4>
      <p>Nutrition & Fitness</p>
    </div>
  </div>

  <div class="colonne">
    <h3>Notre emplacement</h3>
    <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9999999999995!2d2.297643315674123!3d48.87378197928833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc0e0bd1234%3A0xabcdef1234567890!2s60%20Rue%20Fran%C3%A7ois%20Ier%2C%2075008%20Paris!5e0!3m2!1sfr!2sfr!4v1629999999999!5m2!1sfr!2sfr"
          width="100%" height="500" style="border:0;"
          allowfullscreen loading="lazy"
        ></iframe>
  </div>
</section>


<?php include('footer.php'); ?>
