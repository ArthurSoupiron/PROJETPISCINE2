<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription – Sportify</title>
    <link rel="stylesheet" href="styles.css"> <!-- Adaptez selon vos CSS -->
</head>
<body>
    <h2>Inscription</h2>
    <form action="traitement_inscription.php" method="post">
        <!-- Nom -->
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
        </div>

        <!-- Prénom -->
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>

        <!-- E-mail -->
        <div class="form-group">
            <label for="email">E-mail :</label>
            <input type="email" name="email" id="email" required>
        </div>

        <!-- Mot de passe -->
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>
        </div>

        <!-- Sélection du rôle -->
        <div class="form-group">
            <label for="role">Rôle :</label>
            <select name="role" id="role" required>
                <option value="client">Client</option>
                <option value="specialiste">Spécialiste (Coach)</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <!-- Champ « Code Admin » (caché par défaut, n’apparaît que si rôle = admin) -->
        <div class="form-group" id="admin-code-field" style="display: none;">
            <label for="admin_code">Code Admin :</label>
            <input type="password" name="admin_code" id="admin_code">
            <small>Entrez le code secret pour pouvoir créer un compte Administrateur.</small>
        </div>

        <!-- Bouton d’envoi -->
        <div class="form-group">
            <button type="submit">S’inscrire</button>
        </div>
    </form>

    <!-- Petit script pour afficher/cacher le champ « Code Admin » selon le rôle choisi -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const adminCodeField = document.getElementById('admin-code-field');
        const adminCodeInput = document.getElementById('admin_code');

        function toggleAdminCodeField() {
            if (roleSelect.value === 'admin') {
                adminCodeField.style.display = 'block';
                adminCodeInput.setAttribute('required', 'required');
            } else {
                adminCodeField.style.display = 'none';
                adminCodeInput.removeAttribute('required');
                adminCodeInput.value = '';
            }
        }

        // Au chargement de la page, on cache ou affiche selon la valeur courante
        toggleAdminCodeField();

        // À chaque changement du sélecteur « Rôle »
        roleSelect.addEventListener('change', toggleAdminCodeField);
    });
    </script>
</body>
</html>