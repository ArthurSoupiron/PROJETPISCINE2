<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';

$stmt1 = $pdo->query("
    SELECT role, COUNT(*) AS total
    FROM users
    GROUP BY role
");
$stats_roles = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$stmt2 = $pdo->query("SELECT COUNT(*) AS total_coachs FROM coachs");
$total_coachs = $stmt2->fetch(PDO::FETCH_ASSOC)['total_coachs'];
$stmt3 = $pdo->prepare("SELECT COUNT(*) AS total_clients FROM users WHERE role = 'client'");
$stmt3->execute();
$total_clients = $stmt3->fetch(PDO::FETCH_ASSOC)['total_clients'];
$stmt4 = $pdo->query("SELECT COUNT(*) AS total_rdvs FROM rdvs");
$total_rdvs = $stmt4->fetch(PDO::FETCH_ASSOC)['total_rdvs'];
$stmt5 = $pdo->query("
    SELECT statut, COUNT(*) AS total
    FROM rdvs
    GROUP BY statut
");
$rdv_par_statut = $stmt5->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<h2>Statistiques globales</h2>

<section>
    <h3>Utilisateurs par rôle</h3>
    <?php if (count($stats_roles) === 0): ?>
        <p>Aucun utilisateur enregistré.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($stats_roles as $sr): ?>
            <li>
                <?= htmlspecialchars($sr['role']) ?> : <?= htmlspecialchars($sr['total']) ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section>
    <h3>Nombre total de coachs</h3>
    <p><?= htmlspecialchars($total_coachs) ?></p>
</section>

<section>
    <h3>Nombre total de clients</h3>
    <p><?= htmlspecialchars($total_clients) ?></p>
</section>

<section>
    <h3>Rendez-vous</h3>
    <p>Total de rendez-vous : <?= htmlspecialchars($total_rdvs) ?></p>
    <h4>Répartition par statut</h4>
    <?php if (count($rdv_par_statut) === 0): ?>
        <p>Aucun rendez-vous.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($rdv_par_statut as $rps): ?>
            <li>
                <?= htmlspecialchars($rps['statut']) ?> : <?= htmlspecialchars($rps['total']) ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

</main>
</body>
</html>