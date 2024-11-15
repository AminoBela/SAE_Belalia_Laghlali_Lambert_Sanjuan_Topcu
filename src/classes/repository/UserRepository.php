<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\User;
use iutnc\nrv\bd\ConnectionBD;
use PDO;

/**
 * Class UserRepository
 *
 * Classe pour gérer les utilisateurs dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class UserRepository {
    /**
     * @var PDO Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * UserRepository constructor.
     */
    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Vérifie si un email existe déjà dans la base de données.
     *
     * @param string $email L'email à vérifier.
     * @return bool True si l'email existe, false sinon.
     */
    public function chercherEmail(string $email): bool {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Vérifie si un nom d'utilisateur existe déjà dans la base de données.
     *
     * @param string $nomUtilisateur Le nom d'utilisateur à vérifier.
     * @return bool True si le nom d'utilisateur existe, false sinon.
     */
    public function chercherNomUtilisateur(string $nomUtilisateur): bool {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nomUtilisateur' => $nomUtilisateur]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Ajoute un nouvel utilisateur dans la base de données.
     *
     * @param string $nomUtilisateur Le nom d'utilisateur.
     * @param string $email L'email de l'utilisateur.
     * @param string $hashedPassword Le mot de passe haché.
     */
    public function ajouterUtilisateur(string $nomUtilisateur, string $email, string $hashedPassword): void {
        $sql = "INSERT INTO utilisateur (nomUtilisateur, email, motDePasse, role) VALUES (:nomUtilisateur, :email, :motDePasse, :role)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nomUtilisateur' => $nomUtilisateur,
            ':email' => $email,
            ':motDePasse' => $hashedPassword,
            ':role' => 'staff'
        ]);
    }

    /**
     * Cherche un utilisateur par son email.
     *
     * @param string $email L'email de l'utilisateur.
     * @return array|null Les données de l'utilisateur sous forme de tableau associatif ou null si non trouvé.
     */
    public function chercherParEmailUser(string $email): ?array {
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
