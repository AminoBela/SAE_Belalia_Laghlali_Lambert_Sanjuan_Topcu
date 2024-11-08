<?php

namespace iutnc\nrv\auth;

use iutnc\nrv\repositories\UserService;
use iutnc\nrv\exception\AuthException;

class Authentification
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = new UserService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(string $nomUtilisateur, string $email, string $mdp): void
    {
        $emailExistant = $this->repository->chercherEmail($email);
        $nomUtilisateurExistant = $this->repository->chercherNomUtilisateur($nomUtilisateur);

        if ($nomUtilisateurExistant) {
            throw new AuthException("Pseudo déjà utilisé");
        } elseif ($emailExistant) {
            throw new AuthException("Email déjà utilisé");
        } elseif (strlen($mdp) < 8) {
            throw new AuthException("Mot de passe trop court");
        } else {
            $mdpHash = password_hash($mdp, PASSWORD_BCRYPT);
            $this->repository->ajouterUtilisateur($nomUtilisateur, $email, $mdpHash);
        }
    }

    public function login(string $email, string $mdp): bool
    {
        $user = $this->repository->chercherParEmailUser($email);

        if ($user == null || !password_verify($mdp, $user['motDePasse'])) {
            throw new AuthException("Mot de passe ou email incorrect");
        }

        $_SESSION['user'] = $user;

        return true;
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }

    public function getRepository()
    {
        return $this->repository;
    }


}
