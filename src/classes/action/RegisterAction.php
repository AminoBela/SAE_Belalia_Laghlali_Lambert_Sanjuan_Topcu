<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\renderer\RendererRegister;
use iutnc\nrv\repository\UserRepository;
use iutnc\nrv\exception\AuthException;
use Exception;

/**
 * Action pour la page d'inscription. Fonctionnalite 14.
 */

// TODO Donner les droits de creer des utilisateurs a l'utilisateur admin

class RegisterAction extends Action
{

    /**
     * Attribut pour la gestion de l'authentification.
     * @var Authentification Gestion de l'authentification.
     */
    private Authentification $auth;

    /**
     * Constructeur de l'action, initialise l'authentification.
     */
    public function __construct()
    {
        parent::__construct();
        $repository = new UserRepository();
        $this->auth = new Authentification($repository);
        if ($this->auth->isLogged()) {
            header('Location: ?action=home');
            exit();
        }
    }

    /**
     * Methode qui execute l'action.
     * @return string
     */
    public function execute(): string
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomUtilisateur = htmlspecialchars($_POST['nomUtilisateur'], ENT_QUOTES,'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES,'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES,'UTF-8');
            $passwordConfirm = htmlspecialchars($_POST['passwordConfirm'], ENT_QUOTES,'UTF-8');

            try {
                $auth = new Authentification(new UserRepository());
                $auth->register($nomUtilisateur, $email, $password, $passwordConfirm);
                header('Location: ?action=login');
                exit();
            } catch (AuthException $e) {
                $error = $e->getMessage();
            } catch (Exception $e) {
                $error = 'Un erreur inattendue est survenue. Veuillez réessayer plus tard.';
            }
        }
        $renderer = new RendererRegister();
        return $renderer->render(['error' => $error]);
    }
}