<?php
session_start();
// on vérifie que l’utilisateur est bien connecté et a le rôle admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
?>
<?php include 'header.php'; ?>

    <h2>Panneau d’administration</h2>
    <p>Bienvenue, Administrateur !</p>

    <section>
        <h3>Gestion des utilisateurs</h3>
        <ul>
            <li><a href="liste_utilisateurs.php">Voir tous les utilisateurs</a></li>
            <li><a href="ajouter_coach.php">Ajouter un nouveau coach</a></li>       
        </ul>
    </section>

    <section>
        <h3>Paramètres du site</h3>
        <ul>
            <li><a href="gestion_specialites.php">Gérer les spécialités</a></li>
            <li><a href="statistiques.php">Consulter les statistiques</a></li>
        </ul>
    </section>

</main>
</body>
</html>
