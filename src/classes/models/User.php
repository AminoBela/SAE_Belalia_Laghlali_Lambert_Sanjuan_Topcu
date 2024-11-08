<?php

namespace iutnc\nrv\models;

class User {
    private int $id;
    private string $email;
    private string $nomUtilisateur;
    private string $hashedPassword;
    private int $role;


    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    public function getRoleName(): string {
        return $this->role === self::ROLE_ADMIN ? 'Admin' : 'Staff';
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

    public function isAdmin(): bool {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool {
        return $this->role === self::ROLE_STAFF;
    }
}
