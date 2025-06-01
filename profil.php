<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$pageTitle = "Mon Compte - Sportify";
include('header.php');

// Récupération des données de l'utilisateur depuis la session
$prenom = $_SESSION['prenom'];
$nom = $_SESSION['nom'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?> 

<section class="profil-section">
    <div class="container">
        <h2>Bienvenue, <?= htmlspecialchars($prenom) ?> !</h2>
        <p>Rôle : <strong><?= ucfirst($role) ?></strong></p>
        <p>Email : <?= htmlspecialchars($email) ?></p>

        <hr>

        <?php if ($role === 'client'): ?>
            <h3>Mes fonctionnalités client</h3>
            <ul>
                <li><a href="prendre_rdv.php">Prendre un rendez-vous</a></li>
                <li><a href="mes_rendezvous.php">Voir mes rendez-vous</a></li>
                <li><a href="messagerie.php">Messagerie</a></li>
            </ul>

        <?php elseif ($role === 'specialiste'): ?>
            <h3>Outils pour les spécialistes</h3>
            <ul>
                <li><a href="planning_specialiste.php">Voir mon planning</a></li>
                <li><a href="ajouter_disponibilite.php">Ajouter des disponibilités</a></li>
                <li><a href="messagerie.php">Messagerie</a></li>
            </ul>

        <?php elseif ($role === 'admin'): ?>
            <h3>Interface administrateur</h3>
            <ul>
                <li><a href="ajouter_specialiste.php">Ajouter un spécialiste</a></li>
                <li><a href="gestion_utilisateurs.php">Gérer les utilisateurs</a></li>
                <li><a href="gestion_rendezvous.php">Gérer les rendez-vous</a></li>
            </ul>
        <?php endif; ?>

        <hr>
        <p><a href="logout.php" class="logout-btn">Se déconnecter</a></p>
    </div>
</section>

<?php include('footer.php'); ?>
