<?php
session_start();
require_once 'config.php'; // Votre connexion PDO vers MySQL (ex : $pdo = new PDO(...))

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Vérification que tous les champs de base sont envoyés et non vides
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

        // 2) Validation du rôle choisi
        $autorized_roles = ['client', 'specialiste', 'admin'];
        if (in_array($_POST['role'], $autorized_roles)) {
            $role = $_POST['role'];
        } else {
            // Si valeur non reconnue, on force par défaut sur "client"
            $role = 'client';
        }

        // 3) S’il s’agit d’un compte « admin », on vérifie le code secret
        if ($role === 'admin') {
            if (!isset($_POST['admin_code']) || $_POST['admin_code'] !== '123') {
                // Code manquant ou incorrect : on refuse l’inscription
                echo "Code Admin incorrect ! Vous n’êtes pas autorisé(e) à créer un compte administrateur.";
                echo " <a href='inscription.php'>Retour à l’inscription</a>";
                exit;
            }
        }

        // 4) On vérifie qu’aucun autre utilisateur n’a déjà enregistré ce même e-mail
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            echo "Cet e-mail est déjà utilisé. <a href='inscription.php'>Retour</a>";
            exit;
        }

        // 5) Insertion en base avec le rôle choisi
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
    // Si on arrive ici sans passer par le formulaire POST
    header('Location: inscription.php');
    exit;
}
