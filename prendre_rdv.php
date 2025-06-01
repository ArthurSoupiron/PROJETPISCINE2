<?php
$pageTitle = 'Sportify : Prendre un Rendez-vous';
include('header.php');
?>

<main class="rdv-page">
  <section class="container">
    <h2>Prendre un rendez-vous avec Coach DUMAIS, Guy</h2>
    <p>
      Cliquez sur un créneau disponible pour le réserver. Les créneaux disponibles sont en blanc.
      Les créneaux déjà pris sont en bleu et ne sont pas cliquables.
    </p>

    <table class="rdv-table">
      <thead>
        <tr>
          <th>Spécialité</th>
          <th>Médecin</th>
          <th>Lundi PM</th>
          <th>Mercredi AM</th>
          <th>Mercredi PM</th>
          <th>Vendredi AM</th>
          <th>Vendredi PM</th>
        </tr>
      </thead> 
      <tbody>
        <tr>
          <td>Coach, Musculation</td>
          <td>DUMAIS, Guy</td>
          <?php
          // Simule des créneaux disponibles (blanc) et réservés (bleu)
          $creneaux = [
            ['14:00', false], ['09:00', false], ['09:20', false], ['09:40', false], ['14:00', false],
            ['14:20', true],  ['09:20', true],  ['10:00', true],  ['10:20', true],  ['14:20', true],
            ['14:40', false], ['09:40', false], ['10:20', false], ['10:40', false], ['14:40', false],
            ['15:00', true],  ['10:00', true],  ['10:40', true],  ['11:00', true],  ['15:00', true],
            ['15:20', false], ['10:20', false], ['11:00', false], ['11:20', false], ['15:20', false],
            ['15:40', true],  ['10:40', true],  ['11:20', true],  ['11:40', true],  ['15:40', true],
            ['16:00', false], ['11:00', false], ['11:40', false], ['12:00', false], ['16:00', false],
            ['16:20', true],  ['11:20', true],  ['12:00', true],  ['12:20', true],  ['16:20', true],
            ['16:40', false], ['11:40', false], ['12:20', false], ['12:40', false], ['16:40', false],
            ['17:00', true],  ['12:00', true],  ['13:00', true],  ['13:20', true],  ['17:00', true],
            ['17:20', false], ['12:20', false], ['13:20', false], ['13:40', false], ['17:20', false],
            ['17:40', true],  ['12:40', true],  ['13:40', true],  ['14:00', true],  ['17:40', true],
            ['18:00', false], ['13:00', false], ['14:00', false], ['14:20', false], ['18:00', false]
          ];

          foreach (array_chunk($creneaux, 5) as $ligne) {
            foreach ($ligne as [$heure, $reserve]) {
              if ($reserve) {
                echo "<td class='rdv-reserved'>$heure</td>";
              } else {
                echo "<td class='rdv-available'><a href='#'>$heure</a></td>";
              }
            }
            break; // afficher uniquement la première ligne pour exemple
          }
          ?>
        </tr>
      </tbody>
    </table>

    <p class="note">
      Vous recevrez une confirmation de votre RDV par SMS ou courriel. Le créneau deviendra bleu s’il est réservé.
    </p>

    <div class="rdv-buttons">
      <a href="communiquer.php" class="btn">Communiquer avec le coach</a>
      <a href="cv_coach.php" class="btn btn-secondary">Voir son CV</a>
    </div>
  </section>
</main>

<?php include('footer.php'); ?>
