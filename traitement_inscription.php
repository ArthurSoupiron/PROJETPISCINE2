<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //on  Vérifi que tous les champs de base sont envoyés et non vides
    if (
        isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mot_de_passe'], $_POST['role'])
        && !empty($_POST['nom'])
        && !empty($_POST['prenom'])
        && !empty($_POST['email'])
        && !empty($_POST['mot_de_passe'])
        && !empty($_POST['role'])
    ) {
        $nom          = htmlspecialchars(trim($_POST['nom']));
        $prenom       = htmlspecialchars(trim($_POST['prenom']));
        $email        = strtolower(trim($_POST['email']));
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

        // ici nous validons le role choisi
        $autorized_roles = ['client', 'specialiste', 'admin'];
        if (in_array($_POST['role'], $autorized_roles)) {
            $role = $_POST['role'];
        } else {
            // Si la valeur est non reconnue, on force par défaut le compte client
            $role = 'client';
        }

        // si il demande un code admin , il faut que l'utilisateur rentre le mot de passe secret qui est 123
        if ($role === 'admin') {
            if (!isset($_POST['admin_code']) || $_POST['admin_code'] !== '123') {
                // Code de manquant ou incorrect : on refuse l’inscription
                echo "Code Admin incorrect ! Vous n’êtes pas autorisé(e) à créer un compte administrateur.";
                echo " <a href='inscription.php'>Retour à l’inscription</a>";
                exit;
            }
        }

        //cela nous permet de verifier d'un utilisateur n'a pas deja utilise cette email
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            echo "Cet e-mail est déjà utilisé. <a href='inscription.php'>Retour</a>";
            exit;
        }

        $insert = $pdo->prepare("
            INSERT INTO users (nom, prenom, email, mot_de_passe, role)
            VALUES (?, ?, ?, ?, ?)
        ");
        $success = $insert->execute([$nom, $prenom, $email, $mot_de_passe, $role]);

        if ($success) {
            echo "Inscription réussie (rôle : <strong>$role</strong>).";
            echo " <a href='connexion.php'>Se connecter</a>";
            exit;
        } else {
            echo "Une erreur est survenue lors de l'inscription. <a href='inscription.php'>Réessayer</a>";
            exit;
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires. <a href='inscription.php'>Retour</a>";
        exit;
    }
} else {
    header('Location: inscription.php');
    exit;
}
