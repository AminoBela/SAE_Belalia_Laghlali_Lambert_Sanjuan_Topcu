<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\renderer\RendererLogin;
use Exception;
use iutnc\nrv\repositories\UserService;

class LoginAction extends Action
{
    private Authentification $auth;

    public function __construct()
    {
        parent::__construct();
        $repository = new UserService();
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
                    $role = $this->auth->getRepository()->getRole($email);
                    if ($role == 'Admin') {
                        $_SESSION['role'] = 'Admin';
                    } else {
                        $_SESSION['role'] = 'staff';
                    }

                    header('Location: ?action=home');
                    exit();
                }
            } catch (Exception $e) {
                $error = "Erreur lors de la connexion: " . $e->getMessage();
            }
        }

        $renderer = new RendererLogin();
        return $renderer->render($error);
    }
}