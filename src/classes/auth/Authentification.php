<?php

namespace iutnc\nrv\auth;

use iutnc\nrv\repository\UserRepository;
use iutnc\nrv\exception\AuthException;
use iutnc\nrv\models\User;

/**
 * Classe pour la gestion de l'authentification.
 */
class Authentification
{

    /**
     * Attribut pour le repository des utilisateurs.
     * @var UserRepository Repository des utilisateurs.
     */
    private UserRepository $repository;

    /**
     * Constructeur de la classe, initialise le repository.
     * @param UserRepository $repository Repository des utilisateurs.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Methode pour l'inscription d'un utilisateur.
     * @param string $nomUtilisateur Nom de l'utilisateur.
     * @param string $email Email de l'utilisateur.
     * @param string $mdp Mot de passe de l'utilisateur.
     * @param string $mdpConfirm Confirmation du mot de passe.
     * @throws AuthException
     */
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

    /**
     * Methode pour la connexion d'un utilisateur.
     * @param string $email Email de l'utilisateur.
     * @param string $mdp Mot de passe de l'utilisateur.
     * @return bool
     * @throws AuthException
     */
    public function login(string $email, string $mdp): bool {
        $user = $this->repository->chercherParEmailUser($email);

        if (!$user || !password_verify($mdp, $user['motDePasse'])) {
            throw new AuthException("Mot de passe ou email incorrect.");
        }

        $_SESSION['user_id'] = $user['idUtilisateur'];
        $_SESSION['user_role'] = $user['role'];

        return true;
    }

    /**
     * Methode pour verifier si un utilisateur est connecté.
     * @return bool
     */
    public static function isLogged(): bool {
        return isset($_SESSION['user_id']);
    }

    /**
     * Methode pour la deconnexion d'un utilisateur.
     */
    public static function logout(): void {
        session_destroy();
    }

    /**
     * Methode pour obtenir le role d'un utilisateur.
     * @param string $email Email de l'utilisateur.
     * @return string|null
     */
    public static function getRole(string $email): ?string {
        $repository = new UserRepository();
        $user = $repository->chercherParEmailUser($email);
        return $user ? $user['role'] : null;
    }
}