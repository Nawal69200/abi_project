<?php
namespace App\Models;

use PDO;

/**
 * Class User
 * Gère les opérations liées aux utilisateurs dans la base de données.
 */
class User {
    private $conn; // Instance de connexion PDO

    /**
     * User constructor.
     *
     * @param PDO $db Instance de connexion à la base de données.
     */
    public function __construct($db) {
        $this->conn = $db; // Initialiser la connexion
    }

    /**
     * Connexion de l'utilisateur.
     *
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe
     * @return array|false Retourne les informations de l'utilisateur en cas de succès, sinon false.
     */
    public function login($username, $password) {
        $sql = "SELECT * FROM USERS WHERE LOGINUSER = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PASSUSER'])) {
            return $user; // Retourne les infos utilisateur si la connexion réussit
        }

        return false; // Retourne false si la connexion échoue
    }

    /**
     * Vérifie si un utilisateur existe déjà.
     *
     * @param string $username Nom d'utilisateur
     * @return bool Retourne true si l'utilisateur existe, sinon false.
     */
    public function userExists($username) {
        $sql = "SELECT * FROM USERS WHERE LOGINUSER = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false; // Retourne true si l'utilisateur existe
    }

    /**
     * Inscription de l'utilisateur.
     *
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe
     * @return void
     */
    public function register($username, $password) {
        $sql = "INSERT INTO USERS (LOGINUSER, PASSUSER) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute(); // Exécute la requête pour insérer l'utilisateur
    }
}
