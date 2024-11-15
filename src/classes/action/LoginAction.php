<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\renderer\RendererLogin;
use iutnc\nrv\repository\UserRepository;
use iutnc\nrv\exception\AuthException;
use Exception;

/**
 * Action pour la page de connexion, fonctionalité 13.
 */
class LoginAction extends Action
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
     * Exécution de l'action.
     * @return string
     */
    public function execute(): string
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES,'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES,'UTF-8');

            try {
                // si l'authentification réussit, on redirige vers la page d'accueil
                if ($this->auth->login($email, $password)) {
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $this->auth->getRole($email);

                    header('Location: ?action=home');
                    exit();
                }
            } catch (AuthException $e) {
                $error = "Erreur lors de la connexion: " . $e->getMessage();
            } catch (Exception $e) {
                $error = 'An unexpected error occurred. Please try again later.';
            }
        }
        $renderer = new RendererLogin();
        return $renderer->render(['error' => $error]);
    }
}