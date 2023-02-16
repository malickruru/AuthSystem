<?php



// Vérification de la méthode HTTP utilisée
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupération des données du formulaire
  $username = $_POST['username'];
  $password = $_POST['password'];
  $csrf_token = $_POST['csrf_token'];

  // Vérification du jeton CSRF
  if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
    // Le jeton CSRF est invalide, redirection vers la page de connexion avec un message d'erreur
    header('Location: login.php?error=3');
    exit();
  }

  // Récupération des données des utilisateurs depuis le fichier JSON
  $data = file_get_contents('users.json');
  $users = json_decode($data, true);

  // Vérification du nombre de tentatives de connexion infructueuses pour l'utilisateur
  if (isset($users[$username])) {
    // L'utilisateur existe dans le fichier JSON

    if ($users[$username]['failed_attempts'] >= 5) {
      // L'utilisateur a dépassé le nombre maximum de tentatives de connexion infructueuses, redirection vers la page de connexion avec un message d'erreur
      header('Location: login.php?error=2');
      exit();
    }

    // Vérification du mot de passe
    if (password_verify($password, $users[$username]['password'])) {
      // Authentification réussie, création de la session utilisateur et réinitialisation du nombre de tentatives de connexion infructueuses
      $_SESSION['username'] = $username;
      $users[$username]['failed_attempts'] = 0;
      file_put_contents('users.json', json_encode($users));
      header('Location: index.php');
      exit();
    } else {
      // Authentification échouée, mise à jour du nombre de tentatives de connexion infructueuses
      $users[$username]['failed_attempts'] += 1;
      file_put_contents('users.json', json_encode($users));
      header('Location: login.php?error=1');
      exit();
    }
  } else {
    // L'utilisateur n'existe pas dans le fichier JSON, redirection vers la page de connexion avec un message d'erreur
    header('Location: login.php?error=4');
    exit();
  }
}

?>


