<?php
$pageTitle = 'Sportify : Disponibilités des Coachs';
include('header.php');
require_once('connexion.php'); // Connexion à la BDD

// Récupérer tous les coachs
$coachs = $pdo->query("
    SELECT u.id, u.nom, u.prenom, s.telephone 
    FROM users u 
    JOIN specialistes s ON u.id = s.id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container">
    <h2>Disponibilités des Coachs</h2>

    <?php foreach ($coachs as $coach): ?>
        <section class="coach-dispo">
            <h3><?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?></h3>
            <p>Téléphone : <?= htmlspecialchars($coach['telephone']) ?></p>

            <?php
            // Récupérer toutes les disponibilités restantes (non réservées)
            $disponibilites = $pdo->prepare("
                SELECT d.jour_semaine, d.heure_debut
                FROM disponibilites d
                WHERE d.specialiste_id = :id
                AND NOT EXISTS (
                    SELECT 1 FROM rendezvous r
                    WHERE r.specialiste_id = d.specialiste_id
                    AND DAYNAME(r.date_rdv) = d.jour_semaine
                    AND r.heure_rdv = d.heure_debut
                    AND r.statut = 'confirmé'
                )
                ORDER BY FIELD(d.jour_semaine, 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'), d.heure_debut
            ");
            $disponibilites->execute(['id' => $coach['id']]);
            $creneaux = $disponibilites->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (count($creneaux) > 0): ?>
                <ul class="dispo-list">
                    <?php foreach ($creneaux as $slot): ?>
                        <li><?= $slot['jour_semaine'] ?> à <?= substr($slot['heure_debut'], 0, 5) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="prendre_rdv.php?coach_id=<?= $coach['id'] ?>" class="btn">Prendre un RDV</a>
            <?php else: ?>
                <p class="no-dispo">Aucune disponibilité pour ce coach actuellement.</p>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</main>

<style>
.coach-dispo {
    margin-bottom: 30px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 20px;
}
.dispo-list {
    list-style: none;
    padding: 0;
}
.dispo-list li {
    background: #f0f8ff;
    margin-bottom: 5px;
    padding: 8px;
    border-radius: 4px;
}
.no-dispo {
    color: red;
    font-style: italic;
}
</style>

<?php include('footer.php'); ?>
