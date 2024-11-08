<?php

namespace iutnc\nrv\models;

class User {
    private int $id;
    private string $email;
    private string $nomUtilisateur;
    private string $hashedPassword;
    private int $role;

    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;

    public function __construct(int $id, string $email, string $nomUtilisateur, string $hashedPassword, int $role) {
        $this->id = $id;
        $this->email = $email;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->hashedPassword = $hashedPassword;
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

    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }

    public function getRole(): int {
        return $this->role;
    }

    public function isAdmin(): bool {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool {
        return $this->role === self::ROLE_STAFF;
    }
}
