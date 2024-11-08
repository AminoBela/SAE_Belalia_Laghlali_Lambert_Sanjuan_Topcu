<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\renderer\RendererLogin;
use iutnc\nrv\repository\UserRepository;
use iutnc\nrv\exception\AuthException;
use iutnc\nrv\models\User;

class LoginAction extends Action
{
    private Authentification $auth;

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

    public function execute(): string
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            try {
                if ($this->auth->login($email, $password)) {
                    $_SESSION['email'] = $email;
                    // etablir le role de l'utilisateur
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