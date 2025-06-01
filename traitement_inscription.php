<?php
session_start();
require_once 'config.php'; // Assure-toi que ce fichier contient ta connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécurité : vérification que tous les champs sont bien envoyés
    if (
        isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mot_de_passe'])
        && !empty($_POST['nom'])
        && !empty($_POST['prenom'])
        && !empty($_POST['email'])
        && !empty($_POST['mot_de_passe'])
    ) {
        $nom         = htmlspecialchars(trim($_POST['nom']));
        $prenom      = htmlspecialchars(trim($_POST['prenom']));
        $email       = strtolower(trim($_POST['email']));
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash sécurisé
        $role        = 'client'; // Par défaut, les inscrits sont des clients

        // Vérifier si l'email existe déjà
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            echo "Cet email est déjà utilisé. <a href='inscription.php'>Retour</a>";
            exit;
        }

        // Insertion de l'utilisateur
        $insert = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
        if ($insert->execute([$nom, $prenom, $email, $mot_de_passe, $role])) {
            echo "Inscription réussie. <a href='connexion.php'>Se connecter</a>";
            exit;
        } else {
            echo "Une erreur est survenue lors de l'inscription.";
            exit;
        }
    } else {
        echo "Veuillez remplir tous les champs. <a href='inscription.php'>Retour</a>";
        exit;
    }
} else {
    header('Location: inscription.php');
    exit;
}
