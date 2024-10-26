<?php
namespace App\Controllers;

use App\Models\User;

/**
 * Class UserController
 * Gère la logique des utilisateurs, y compris la connexion et l'inscription.
 */
class UserController {
    private $userModel; // Modèle utilisateur

    /**
     * UserController constructor.
     *
     * @param PDO $db Instance de connexion à la base de données.
     */
    public function __construct($db) {
        $this->userModel = new User($db); // Initialiser le modèle utilisateur
    }

    /**
     * Gérer la tentative de connexion de l'utilisateur.
     *
     * @return void
     */
    public function processLogin() {
        if (session_status() === PHP_SESSION_NONE) { // Vérifier si la session n'est pas démarrée
            session_start(); // Démarrer la session ici
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']; // Nom d'utilisateur
            $password = $_POST['password']; // Mot de passe

            // Vérification des informations de connexion
            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Si la connexion est réussie, stocker les informations dans la session
                $_SESSION['user_id'] = $user['IDUSER'];
                $_SESSION['username'] = $user['LOGINUSER'];

                // Redirection vers le tableau de bord
                header('Location: /abi_project/Views/dashboard.php'); 
                exit();
            } else {
                // En cas d'échec de la connexion
                header('Location: /abi_project/Views/login.php?error=1');
                exit();
            }
        }
    }

    /**
     * Gérer l'inscription d'un nouvel utilisateur.
     *
     * @return void
     */
    public function processRegister() {
        if (session_status() === PHP_SESSION_NONE) { // Vérifier si la session n'est pas démarrée
            session_start(); // Démarrer la session ici
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_username = $_POST['new_username']; 
            $new_password = $_POST['new_password']; 

            // Hachage du mot de passe pour la sécurité
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Vérifier si l'utilisateur existe déjà
            if ($this->userModel->userExists($new_username)) {
                // L'utilisateur existe déjà, redirection avec message d'erreur
                header('Location: /abi_project/Views/register.php?error=2');
                exit();
            } else {
                // Créer le nouvel utilisateur dans la base de données
                $this->userModel->register($new_username, $hashed_password);

                // Redirection vers la page de connexion après inscription réussie
                header('Location: /abi_project/Views/login.php?success=1');
                exit();
            }
        }
    }
}
