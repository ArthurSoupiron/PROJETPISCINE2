<?php
$pageTitle = "Connexion - Sportify";
include('header.php');
?>

<style>
  .form-container {
    max-width: 500px;
    margin: 3rem auto;
    padding: 2rem;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    border-radius: 10px;
  }

  .form-container h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #2d3748;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #333;
  }

  .form-group input {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
  }

  button {
    width: 100%;
    padding: 0.75rem;
    background-color: #2d3748;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
  }

  button:hover {
    background-color: #1a202c;
  }

  .form-footer {
    text-align: center;
    margin-top: 1rem;
  }

  .form-footer a {
    color: #3182ce;
  }

  .error {
    color: red;
    text-align: center;
    margin-bottom: 1rem;
  }
</style>

<div class="form-container">
  <h2>Connexion</h2>

  <?php if (!empty($_GET['erreur'])): ?>
    <div class="error"><?= htmlspecialchars($_GET['erreur']) ?></div>
  <?php endif; ?>

  <form action="traitement_connexion.php" method="POST">
    <div class="form-group">
      <label for="email">Adresse email</label>
      <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
      <label for="mot_de_passe">Mot de passe</label>
      <input type="password" name="mot_de_passe" id="mot_de_passe" required>
    </div>

    <button type="submit">Se connecter</button>

    <div class="form-footer">
      <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
    </div>
  </form>
</div>

<?php include('footer.php'); ?>
