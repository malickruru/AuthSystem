<?php 

// Démarrage de la session
session_start();

// Génération d'un jeton CSRF aléatoire
$csrf_token = bin2hex(random_bytes(32));

// Stockage du jeton CSRF dans la session
$_SESSION['csrf_token'] = $csrf_token;



// Inclure le fichier error.php
require_once('error.php');

// Vérifier si une erreur a été renvoyée
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    $error_message = get_error_message($error_code);
    echo '<p class="error">' . $error_message . '</p>';
}
?>



<form action="check_login.php" method="POST">
  <label for="username">Nom d'utilisateur :</label>
  <input type="text" name="username" id="username">
  <br>
  <label for="password">Mot de passe :</label>
  <input type="password" name="password" id="password">
  <br>
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
  <input type="submit" value="Se connecter">
</form>
