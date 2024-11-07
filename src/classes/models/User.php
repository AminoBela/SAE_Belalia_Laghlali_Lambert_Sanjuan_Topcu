<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

/**
 * Class User qui peut être un organisateur d'une soirée ou l'admin sinon le reste sont anonyme (visiteurs)
 */
class User {
    private int $id;

    private string $email;

    private string $nomUtilisateur;

    private string $password;

    private int $role;

    public function __construct(int $id, string $email, string $nomUtilisateur, string $password, int $role) {
        $this->id = $id;
        $this->email = $email;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getNomUtilisateur(): string {
        return $this->nomUtilisateur;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): int {
        return $this->role;
    }
}
