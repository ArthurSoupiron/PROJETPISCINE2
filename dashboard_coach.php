<?php
session_start();
// Vérifie que l’utilisateur est bien connecté et a le rôle "specialiste" (coach)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'specialiste') {
    header('Location: connexion.php');
    exit;
}
?>
<?php include 'header.php'; ?>

    <h2>Dashboard Coach</h2>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom'] ?? 'Coach'); ?> !</p>

    <section>
        <h3>Vos prochains rendez-vous</h3>
        <ul>
            <li>Aucun rendez-vous prévu pour le moment.</li>
        </ul>
    </section>

    <section>
        <h3>Actions rapides</h3>
        <ul>
            <li><a href="profil.php">Voir mon profil</a></li>
            <li><a href="prendre_rdv.php">Voir/traiter les demandes de rendez-vous</a></li>
        </ul>
    </section>

</main>
</body>
</html>