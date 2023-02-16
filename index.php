<?php

// Vérification de la session utilisateur
session_start();
if (!isset($_SESSION['username'])) {
  // Utilisateur non connecté, redirection vers la page de connexion
  header('Location: login.php');
  exit();
}

// Affichage du contenu de la page protégée
echo "Bienvenue, " . $_SESSION['username'] . " !";
