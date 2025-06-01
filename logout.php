<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil ou de connexion
header("Location: index.php"); // ou login.php si vous avez une page de connexion
exit();
?>
