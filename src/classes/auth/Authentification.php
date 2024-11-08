<?php

namespace iutnc\nrv\auth;

use iutnc\nrv\repository\UserRepository;
use iutnc\nrv\exception\AuthException;
use iutnc\nrv\models\User;

class Authentification
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(string $nomUtilisateur, string $email, string $mdp, string $mdpConfirm): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AuthException("Email invalide");
        }
        if ($this->repository->chercherEmail($email)) {
            throw new AuthException("Email déjà utilisé");
        }
        if ($this->repository->chercherNomUtilisateur($nomUtilisateur)) {
            throw new AuthException("Nom d'utilisateur déjà utilisé");
        }
        if (strlen($mdp) < 8) {
            throw new AuthException("Mot de passe trop court");
        }
        if ($mdp !== $mdpConfirm) {
            throw new AuthException("Les mots de passe ne correspondent pas");
        }
        $hashedMdp = password_hash($mdp, PASSWORD_BCRYPT);
        $this->repository->ajouterUtilisateur($nomUtilisateur, $email, $hashedMdp, User::ROLE_STAFF);
    }

    public function login(string $email, string $mdp): bool {
        $user = $this->repository->chercherParEmailUser($email);

        if (!$user || !password_verify($mdp, $user['motDePasse'])) {
            throw new AuthException("Mot de passe ou email incorrect.");
        }

        $_SESSION['user_id'] = $user['idUtilisateur'];
        $_SESSION['user_role'] = $user['role'];

        return true;
    }

    public static function isLogged(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function logout(): void {
        session_destroy();
    }

    public static function getRole(string $email): ?int {
        $repository = new UserRepository();
        $user = $repository->chercherParEmailUser($email);
        return $user ? $user['rôle'] : null;
    }
}