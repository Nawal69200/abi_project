<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirige vers la page de connexion
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> !</h1>
    <p>Vous êtes connecté.</p>

    <!-- Lien vers la page de déconnexion -->
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
