<?php
session_start(); // Démarrer la session

// Si l'utilisateur est déjà connecté, redirection vers le tableau de bord
if (isset($_SESSION['user_id'])) {
    header('Location: /abi_project/Views/dashboard.php');
    exit();
}

require_once '../vendor/autoload.php'; // Charger les dépendances

use App\Controllers\UserController;
use App\Models\Database;

// Connexion à la base de données via PDO
$database = new Database();
$db = $database->connect();
$userController = new UserController($db);

// Gérer la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->processLogin();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <h1>Connexion</h1>

    <!-- Afficher un message d'erreur si la connexion échoue -->
    <?php if (isset($_GET['error'])) { ?>
        <p style="color: red;">Nom d'utilisateur ou mot de passe incorrect.</p>
    <?php } ?>

    <!-- Formulaire de connexion -->
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>

    <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire ici</a></p>
</body>
</html>
