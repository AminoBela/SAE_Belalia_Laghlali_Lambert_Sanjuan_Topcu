<?php

namespace iutnc\nrv\auth;

use iutnc\nrv\repository\Repository;
use iutnc\nrv\exception\AuthException;

class Authentification
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(string $pseudo, string $email, string $mdp): void
    {
        $emailExistant = $this->repository->chercherParEmail($email);
        $pseudoExistant = $this->repository->chercherParPseudo($pseudo);

        if ($pseudoExistant) {
            throw new AuthException("Pseudo déjà utilisé");
        } elseif ($emailExistant) {
            throw new AuthException("Email déjà utilisé");
        } elseif (strlen($mdp) < 8) {
            throw new AuthException("Mot de passe trop court");
        } else {
            $mdpHash = password_hash($mdp, PASSWORD_BCRYPT);
            $this->repository->ajouterUtilisateur($pseudo, $email, $mdpHash);
        }
    }

    public function login(string $email, string $mdp): bool
    {
        $user = $this->repository->chercherParEmail($email);

        if ($user == null || !password_verify($mdp, $user->getMdp())) {
            throw new AuthException("Mot de passe ou email incorrect");
        }

        $_SESSION['user']['id'] = $user->getIdUtilisateur();
        $_SESSION['user']['role'] = $user->getRole();
        return true;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }
}
