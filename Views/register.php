<?php
require_once '../vendor/autoload.php'; // Charger les dépendances

use App\Controllers\UserController;
use App\Models\Database;

// Connexion à la base de données via PDO
$database = new Database();
$db = $database->connect();
$userController = new UserController($db);

// Gérer la soumission du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->processRegister();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <h1>Inscription</h1>

    <!-- Afficher un message d'erreur si l'utilisateur existe déjà -->
    <?php if (isset($_GET['error'])) { ?>
        <p style="color: red;">Ce nom d'utilisateur existe déjà. Veuillez en choisir un autre.</p>
    <?php } ?>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="">
        <label for="new_username">Nom d'utilisateur:</label>
        <input type="text" name="new_username" required>
        <br>
        <label for="new_password">Mot de passe:</label>
        <input type="password" name="new_password" required>
        <br>
        <button type="submit" name="register">S'inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="login.php">Se connecter ici</a></p>
</body>
</html>
