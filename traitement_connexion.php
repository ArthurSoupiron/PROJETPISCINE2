<?php
session_start();
require_once('db.php');

// Vérifier que les champs sont bien remplis
if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Rechercher l'utilisateur avec l'email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérifier si un utilisateur est trouvé et si le mot de passe est correct
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Stocker les infos utilisateur dans la session
        // Stocker toutes les infos dans 'user' pour un accès global
        $_SESSION['user'] = $user;

// Et aussi dans des variables séparées si nécessaire
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];


        // Rediriger vers la page d'accueil
        header("Location: index.php");
        exit();
    } else {
        echo "Identifiants invalides. <a href='connexion.php'>Retour</a>";
    }
} else {
    echo "Veuillez remplir tous les champs. <a href='connexion.php'>Retour</a>";
}
