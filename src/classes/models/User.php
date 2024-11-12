<?php

namespace iutnc\nrv\models;

/**
 * Classe pour la gestion des utilisateurs.
 */
class User {

    /**
     * Attributs de la classe.
     * @var int $id Identifiant de l'utilisateur.
     * @var string $email Email de l'utilisateur.
     * @var string $nomUtilisateur Nom de l'utilisateur.
     * @var string $hashedPassword Mot de passe hashé de l'utilisateur.
     * @var int $role Rôle de l'utilisateur.
     */
    private int $id;
    private string $email;
    private string $nomUtilisateur;
    private string $hashedPassword;
    private int $role;

    /**
     * Constantes pour les rôles.
     * @var string ROLE_ADMIN Rôle administrateur.
     * @var string ROLE_STAFF Rôle staff.
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    /**
     * Constructeur de la classe.
     * @return string[] Liste des rôles possibles.
     */
    public function getRoleName(): string {
        return $this->role === self::ROLE_ADMIN ? 'admin' : 'staff';
    }

    /**
     *Getter de l'id de l'utilisateur.
     * @return int Identifiant de l'utilisateur.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Getter de l'email de l'utilisateur.
     * @return string Email de l'utilisateur.
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Getter du nom de l'utilisateur.
     * @return string Nom de l'utilisateur.
     */
    public function getNomUtilisateur(): string {
        return $this->nomUtilisateur;
    }

    /**
     * Getter du mot de passe hashé de l'utilisateur.
     * @return string Mot de passe hashé de l'utilisateur.
     */
    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }

    /**
     * Getter du rôle de l'utilisateur.
     * @return int Rôle de l'utilisateur.
     */
    public function isAdmin(): bool {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Vérifie si l'utilisateur est de role 'staff'.
     * @return bool
     */
    public function isStaff(): bool {
        return $this->role === self::ROLE_STAFF;
    }
}
