<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sportify - Plateforme de rendez-vous sportif</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico"> <!-- Facultatif -->
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="Logo Sportify" height="60"></a>
                <h1>Sportify</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="toutparcourir.php">Tout parcourir</a></li>
                    <li><a href="prendre_rdv.php">Prendre rendez-vous</a></li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'specialiste'): ?>
                        <li><a href="dashboard_coach.php">Espace Coach</a></li>
                    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="admin_panel.php">Administration</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role'])): ?>
                        <li><a href="profil.php">Mon Compte</a></li>
                        <li><a href="logout.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
