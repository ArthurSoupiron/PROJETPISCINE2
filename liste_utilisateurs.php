<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';

// Récupération de tous les utilisateurs
$stmt = $pdo->query("
    SELECT id, nom, prenom, email, role, date_creation
    FROM users
    ORDER BY role, nom, prenom
");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<h2>Liste des utilisateurs</h2>
<?php if (count($utilisateurs) === 0): ?>
    <p>Aucun utilisateur trouvé.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>E-mail</th>
                <th>Rôle</th>
                <th>Date d’inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($utilisateurs as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['nom']) ?></td>
                <td><?= htmlspecialchars($u['prenom']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['role']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($u['date_creation'])) ?></td>
                <td>
                    <!-- Optionnel : lien vers une page de modification ou suppression -->
                    <a href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</main>
</body>
</html>