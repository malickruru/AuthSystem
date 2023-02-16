<?php

function get_error_message($code) {
    switch ($code) {
        case 1:
            return "Authentification échouée,";
        case 2:
            return "L'utilisateur a dépassé le nombre maximum de tentatives de connexion infructueuses,";
        case 3:
            return "Le jeton CSRF est invalide";
        case 4:
            return "L'utilisateur n'existe pas ";
        case 5:
            return "";
        case 6:
            return "";
        default:
            return "Une erreur inconnue s'est produite.";
    }
}

?>
