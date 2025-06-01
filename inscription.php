<?php
$pageTitle = "Inscription - Sportify";
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

  .form-group input, .form-group select {
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
</style>

<div class="form-container">
  <h2>Créer un compte</h2>
  <form action="traitement_inscription.php" method="POST">
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" name="nom" id="nom" required>
    </div>

    <div class="form-group">
      <label for="prenom">Prénom</label>
      <input type="text" name="prenom" id="prenom" required>
    </div>

    <div class="form-group">
      <label for="email">Adresse email</label>
      <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
      <label for="mot_de_passe">Mot de passe</label>
      <input type="password" name="mot_de_passe" id="mot_de_passe" required>
    </div>

    <div class="form-group">
      <label for="role">Rôle</label>
      <select name="role" id="role" required>
        <option value="client">Client</option>
        <option value="specialiste">Spécialiste</option>
        <option value="admin">Administrateur</option>
      </select>
    </div>

    <button type="submit">S'inscrire</button>

    <div class="form-footer">
      <p>Déjà inscrit ? <a href="connexion.php">Connexion</a></p>
    </div>
  </form>
</div>

<?php include('footer.php'); ?>
