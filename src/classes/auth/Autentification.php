<?php

namespace iutnc\nrv\auth;

use iutnc\nrv\repository\Repository;
use iutnc\nrv\exception\AuthException;

/**
 * Classe Autentification
 */
class Autentification
{

    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Methode pour s'inscrire
     * @param string $pseudo
     * @param string $email
     * @param string $mdp
     * @return string
     */
    public static function register(string $pseudo, string $email, string $mdp)
    {

        // Cherche les pseudos et mail tapés existent déjà dans la base de données
        $repository = new Repository();
        $emailExistant = $repository->chercherParEmail($email);
        $pseudoExistant = $repository->chercherParPseudo($pseudo);

        // Si le pseudo ou l'email existe déjà dans la base de données, ou si le mot de passe est trop court, je renvoie un message d'erreur
        // Sinon j'ajoute l'utilisateur dans la base de données
        if ($pseudoExistant != null) {
            throw new AuthException("Pseudo déjà utilisé");
        } elseif ($emailExistant != null) {
            throw new AuthException("Email déjà utilisé");
        } elseif (strlen($mdp) < 8) {
            throw new AuthException("Mot de passe trop court");
        } else {
            $mdpHash = password_hash($mdp, PASSWORD_BCRYPT);
            $repository->ajouterUtilisateur($pseudo, $email, $mdpHash);
            $res = "Inscription réussie";
        }
        return $res;
    }


    /**
     * Se connecter avec un email et un mot de passe
     * @param string $email
     * @param string $mdp
     * @return bool
     * @throws AuthException
     */
    public function login(string $email, string $mdp) : bool
    {
        // Je cherche l'utilisateur par son email (A FAIRE LA METHODE DE RECHERCHE DE L'UTILISATEUR PAR SON EMAIL)
        $user = $this->repository->chercherParEmail($email);

        // Si l'utilisateur n'existe pas ou que le mot de passe est incorrect
        if ($user == null || !password_verify($mdp, $user->getMdp())) {
            throw new AuthException("Mot de passe ou email incorrect");
        }

        // Ici je stocke l'id et le role de l'utilisateur dans la session, l'id c'est pour savoir qui est connecté et le role pour savoir si c'est un admin ou un utilisateur
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['role'] = $user['role'];
        return true;
    }

    /**
     * Se déconnecter
     */
    public function logout() : void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Si l'utilisateur est connecté
     */
    public function isLogged() : bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Getteur du role de l'utilisateur
     */
    public function getRole() : string
    {
        return $_SESSION['user']['role'] ?? '';
    }

    /**
     *
     */

    /**
     * Checker l'access
     */
    public function checkAccess() : bool
    {
        // TODO a faire en fonction des actions et besoins
    }

}