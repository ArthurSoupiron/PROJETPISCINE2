<?php
// connexion/login.php
session_start();

// Traitement du formulaire
$host   = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'sportify_db';

$conn = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, mot_de_passe, type_utilisateur FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();
        // Pour un vrai projet, utiliser password_verify()
        if ($password === $userData['mot_de_passe']) {
            $_SESSION['user_id']          = $userData['id'];
            $_SESSION['type_utilisateur'] = $userData['type_utilisateur'];

            // Redirection selon le type d'utilisateur
            switch ($userData['type_utilisateur']) {
                case 'admin':
                    header("Location: ../admin/admin_dashboard.php");
                    break;
                case 'coach':
                    header("Location: ../coach/coach_dashboard.php");
                    break;
                default:  // client ou autre
                    header("Location: ../general/index.php");
            }
            exit;
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Email non trouvé.";
    }
    $stmt->close();
}
$conn->close();

// Affichage
$pageTitle = 'Sportify : Connexion';
require_once __DIR__ . '/../includes/header.php';
?>

<main>

    <div class="container" style="flex-direction:column; max-width:400px; width:100%;">
      <h2 style="font-size:2rem; color:#2d3748; margin-bottom:1.5rem; text-align:center;">
        Connexion
      </h2>

      <?php if ($error): ?>
        <div class="server-error">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST"
            action="login.php"
            id="loginForm"
            novalidate
            style="width:100%;">

        <div class="field-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" autocomplete="username">
        </div>

        <div class="field-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" autocomplete="current-password">
        </div>

        <button type="submit" class="btn-submit">
          Se connecter
        </button>

        <p class="signup-link">
          Pas encore inscrit ?
          <a href="register.php">Créer un compte</a>
        </p>
      </form>
    </div>
  </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
// Validation custom sur submit
document.getElementById('loginForm').addEventListener('submit', function(e) {
  // Supprime anciens messages
  document.querySelectorAll('.field-error').forEach(el => el.remove());

  let valid = true;

  [
    ['email','Veuillez renseigner votre email.'],
    ['password','Veuillez renseigner votre mot de passe.']
  ].forEach(([id,msg]) => {
    const inp = document.getElementById(id);
    if (!inp.value.trim()) {
      const err = document.createElement('div');
      err.className = 'field-error';
      err.innerText = msg;
      inp.parentNode.appendChild(err);
      valid = false;
    }
  });

  if (!valid) e.preventDefault();
});
</script>

<style>
</style>