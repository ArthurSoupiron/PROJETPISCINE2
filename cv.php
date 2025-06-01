<?php
$coachNom = isset($_GET['coach']) ? $_GET['coach'] : '';
$coachNomSanitized = strtolower(str_replace(' ', '_', $coachNom));
$xmlPath = "cv/CV_$coachNomSanitized.xml";

if (!file_exists($xmlPath)) {
    echo "<h2>CV introuvable</h2><p>Le fichier pour <strong>$coachNom</strong> est manquant.</p>";
    exit;
}

$xml = simplexml_load_file($xmlPath);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CV de <?= $xml->coach->prenom . ' ' . $xml->coach->nom ?></title>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; background: #f9f9f9; }
    h1, h2, h3 { color: #0057a0; }
    ul { padding-left: 20px; }
    .section { margin-bottom: 30px; }
    .photo { max-width: 150px; border-radius: 8px; margin-bottom: 15px; }
  </style>
</head>
<body>

  <h1>CV de <?= $xml->coach->prenom . ' ' . $xml->coach->nom ?></h1>
  <img src="<?= $xml->coach->photo ?>" alt="Photo du coach" class="photo">

  <div class="section">
    <h2>Spécialité</h2>
    <p><?= $xml->coach->specialite ?></p>
  </div>

  <div class="section">
    <h2>Bureau</h2>
    <p><?= $xml->coach->bureau ?></p>
    <p><strong>Email :</strong> <?= $xml->coach->email ?></p>
  </div>

  <div class="section">
    <h2>Formations</h2>
    <ul>
      <?php foreach ($xml->formations->formation as $f): ?>
        <li><strong><?= $f->annee ?></strong> — <?= $f->intitule ?> (<?= $f->ecole ?>)</li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="section">
    <h2>Expériences</h2>
    <ul>
      <?php foreach ($xml->experiences->experience as $e): ?>
        <li>
          <strong><?= $e->poste ?></strong> (<?= $e->debut ?> à <?= $e->fin ?>)<br>
          <em><?= $e->structure ?></em><br>
          <?= htmlspecialchars($e->description) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="section">
    <h2>Contact</h2>
    <p><strong>Téléphone :</strong> <?= $xml->coordonnees->telephone ?></p>
    <p><strong>LinkedIn :</strong> <a href="<?= $xml->coordonnees->linkedin ?>" target="_blank"><?= $xml->coordonnees->linkedin ?></a></p>
  </div>

  <div class="section">
    <h2>Disponibilités</h2>
    <ul>
      <?php foreach ($xml->disponibilites->jour as $jour): ?>
        <li><strong><?= ucfirst($jour['nom']) ?> :</strong>
          <?php
            $creneaux = [];
            foreach ($jour->creneau as $c) {
              $creneaux[] = $c['debut'] . ' - ' . $c['fin'];
            }
            echo implode(', ', $creneaux);
          ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</body>
</html>
