<?php
namespace App\Models;

use PDO;
use PDOException;

/**
 * Class Database
 * Gère la connexion à la base de données.
 */
class Database {
    private $host = 'mysql'; 
    private $db_name = 'gestion_commerciale'; 
    private $username = 'root'; 
    private $password = 'root_password'; 
    private $conn; 

    /**
     * Méthode de connexion à la base de données.
     *
     * @return PDO|null Retourne une instance de PDO si la connexion est réussie, sinon null.
     */
    public function connect() {
        $this->conn = null; // Initialiser la connexion à null

        try {
            // Connexion via PDO
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurer le mode d'erreur
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage(); // Afficher l'erreur de connexion
            exit(); // Terminer le script en cas d'erreur
        }

        return $this->conn; // Retourner l'instance de connexion
    }
}
