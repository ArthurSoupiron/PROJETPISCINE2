<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';

$msg_erreur = '';
$msg_success = '';

//on traite l’ajout d’une nouvelle spécialité
if (isset($_POST['action']) && $_POST['action'] === 'ajout_specialite') {
    $nouvelle = htmlspecialchars(trim($_POST['nouvelle_specialite']));
    if ($nouvelle === '') {
        $msg_erreur = "Le nom de la spécialité ne peut pas être vide.";
    } else {
        // on vérifie  son unicité
        $check = $pdo->prepare("SELECT id FROM specialites WHERE nom_specialite = ?");
        $check->execute([$nouvelle]);
        if ($check->rowCount() > 0) {
            $msg_erreur = "Cette spécialité existe déjà.";
        } else {
            $insert = $pdo->prepare("INSERT INTO specialites (nom_specialite) VALUES (?)");
            $insert->execute([$nouvelle]);
            $msg_success = "Spécialité ajoutée avec succès.";
        }
    }
}

// cela nous permet de supprimer specialite
if (isset($_GET['suppr_id']) && ctype_digit($_GET['suppr_id'])) {
    $idSuppr = (int)$_GET['suppr_id'];
    // Supprimer les liaisons éventuelles dans coach_specialites
    $pdo->prepare("DELETE FROM coach_specialites WHERE id_specialite = ?")->execute([$idSuppr]);
    // Supprimer la spécialité
    $del = $pdo->prepare("DELETE FROM specialites WHERE id = ?");
    $del->execute([$idSuppr]);
    $msg_success = "Spécialité supprimée.";
}

$stmt = $pdo->query("SELECT id, nom_specialite FROM specialites ORDER BY nom_specialite");
$specialites = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<h2>Gestion des spécialités</h2>

<?php if (!empty($msg_erreur)): ?>
    <div style="color: red;"><?= $msg_erreur ?></div>
<?php elseif (!empty($msg_success)): ?>
    <div style="color: green;"><?= $msg_success ?></div>
<?php endif; ?>

<section>
    <h3>Ajouter une nouvelle spécialité</h3>
    <form action="gestion_specialites.php" method="post">
        <input type="hidden" name="action" value="ajout_specialite">
        <div>
            <label for="nouvelle_specialite">Nom :</label>
            <input type="text" name="nouvelle_specialite" id="nouvelle_specialite" required>
            <button type="submit">Ajouter</button>
        </div>
    </form>
</section>

<hr>

// liste des spécialités existantes
<section>
    <h3>Spécialités existantes</h3>
    <?php if (count($specialites) === 0): ?>
        <p>Aucune spécialité trouvée.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la spécialité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($specialites as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['id']) ?></td>
                    <td><?= htmlspecialchars($s['nom_specialite']) ?></td>
                    <td>
                        <a href="gestion_specialites.php?suppr_id=<?= $s['id'] ?>"
                           onclick="return confirm('Supprimer cette spécialité ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

</main>
</body>
</html>
