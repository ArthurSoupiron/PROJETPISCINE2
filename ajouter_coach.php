<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';

$msg_erreur = '';
$msg_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Création de l'utilisateur dans users
    $nom       = htmlspecialchars(trim($_POST['nom']));
    $prenom    = htmlspecialchars(trim($_POST['prenom']));
    $email     = strtolower(trim($_POST['email']));
    $mdp_hache = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Vérification unicité email
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        $msg_erreur = "Cet e-mail est déjà utilisé.";
    } else {
        $insertUser = $pdo->prepare("
            INSERT INTO users (nom, prenom, email, mot_de_passe, role)
            VALUES (?, ?, ?, ?, 'specialiste')
        ");
        if ($insertUser->execute([$nom, $prenom, $email, $mdp_hache])) {
            $idUser = $pdo->lastInsertId();

            // 2) Upload photo (facultatif)
            $cheminPhoto = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $dossier  = 'uploads/coachs/';
                if (!is_dir($dossier)) mkdir($dossier, 0755, true);
                $tmp_name = $_FILES['photo']['tmp_name'];
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $nomFichier = 'coach_' . $idUser . '.' . $ext;
                move_uploaded_file($tmp_name, $dossier . $nomFichier);
                $cheminPhoto = $dossier . $nomFichier;
            }

            // 3) Insertion dans coachs
            $specialite    = htmlspecialchars(trim($_POST['specialite']));
            $cv            = htmlspecialchars(trim($_POST['cv']));
            $dispo_semaine = json_encode($_POST['dispo_semaine'] ?? []);

            $insertCoach = $pdo->prepare("
                INSERT INTO coachs (id_user, photo, specialite, cv, dispo_semaine)
                VALUES (?, ?, ?, ?, ?)
            ");
            $insertCoach->execute([$idUser, $cheminPhoto, $specialite, $cv, $dispo_semaine]);

            $msg_success = "Le coach a été ajouté avec succès.";
        } else {
            $msg_erreur = "Erreur lors de la création de l'utilisateur.";
        }
    }
}

include 'header.php';
?>

<h2>Ajouter un coach</h2>

<?php if (!empty($msg_erreur)): ?>
    <div style="color: red;"><?= $msg_erreur ?></div>
<?php elseif (!empty($msg_success)): ?>
    <div style="color: green;"><?= $msg_success ?></div>
<?php endif; ?>

<form action="ajouter_coach.php" method="post" enctype="multipart/form-data">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
    </div>
    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
    </div>
    <div>
        <label for="email">E-mail :</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>
    </div>
    <div>
        <label for="photo">Photo (JPG/PNG) :</label>
        <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png">
    </div>
    <div>
        <label for="specialite">Spécialité :</label>
        <input type="text" name="specialite" id="specialite" required>
    </div>
    <div>
        <label for="cv">CV (texte libre) :</label><br>
        <textarea name="cv" id="cv" rows="4"></textarea>
    </div>
    <div>
        <label for="dispo_semaine">Disponibilités (JSON ou vide) :</label><br>
        <textarea name="dispo_semaine" id="dispo_semaine" rows="2" placeholder='{"lundi":["09:00","10:00"],"mardi":["15:00"]}'></textarea>
    </div>
    <div>
        <button type="submit">Ajouter le coach</button>
    </div>
</form>

</main>
</body>
</html>