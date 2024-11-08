<?php

namespace iutnc\nrv\repositories;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class UserService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function chercherEmail(string $email)
    {
        $sql = "SELECT email FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function chercherNomUtilisateur(string $nomUtilisateur)
    {
        $sql = "SELECT nomUtilisateur FROM utilisateur WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nomUtilisateur' => $nomUtilisateur]);
        return $stmt->fetch();
    }

    public function ajouterUtilisateur(string $nomUtilisateur, string $email, string $mdpHash)
    {
        $sql = "INSERT INTO utilisateur (nomUtilisateur, email, motDePasse, rôle) VALUES (:nomUtilisateur, :email, :motDePasse, :role)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nomUtilisateur' => $nomUtilisateur,
            ':email' => $email,
            ':motDePasse' => $mdpHash,
            ':role' => 'staff'
        ]);
    }

    public function chercherParEmailUser(string $email)
    {
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getRole(string $email)
    {
        $sql = "SELECT rôle FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getMdp(string $email)
    {
        $sql = "SELECT motDePasse FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getNomUtilisateur(string $email)
    {
        $sql = "SELECT nomUtilisateur FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getIDUtilisateur(string $email)
    {
        $sql = "SELECT idUtilisateur FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }


}