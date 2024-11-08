<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\User;
use iutnc\nrv\bd\ConnectionBD;
use PDO;

class UserRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function chercherEmail(string $email): bool {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function chercherNomUtilisateur(string $nomUtilisateur): bool {
        $sql = "SELECT COUNT(*) FROM utilisateur WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nomUtilisateur' => $nomUtilisateur]);
        return $stmt->fetchColumn() > 0;
    }

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

    public function chercherParEmailUser(string $email): ?array {
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
