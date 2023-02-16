<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Charger le contenu du fichier user.json
    $json = file_get_contents('user.json');
    $users = json_decode($json, true);

    // Vérifier si l'email est déjà utilisé
    if (array_key_exists($email, $users)) {
        $error = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        // Vérifier si les mots de passe correspondent
        if ($password == $confirm_password) {
            // Hacher le mot de passe avec l'algorithme de hachage bcrypt
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Ajouter l'utilisateur dans le tableau d'utilisateurs
            $users[$email] = array(
                'password' => $hashed_password,
                'failed_attempts' => 0
            );

            // Enregistrer les modifications dans le fichier user.json
            $json = json_encode(array('users' => $users));
            file_put_contents('user.json', $json);

            // Rediriger l'utilisateur vers la page de connexion
            header('Location: login.php');
            exit;
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
