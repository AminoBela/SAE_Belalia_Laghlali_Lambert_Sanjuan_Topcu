<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\renderer\RendererRegister;
use iutnc\nrv\repositories\UserService;
use iutnc\nrv\repository\User;

class RegisterAction extends Action
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
            $nomUtilisateur = filter_var($_POST['nomUtilisateur'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            try {
                if ($this->auth->register($nomUtilisateur, $email, $password)) {
                    $_SESSION['email'] = $email;
                    if (UserService::getRole($email) == 'Admin') {
                        $_SESSION['role'] = 'Admin';
                    } else {
                        $_SESSION['role'] = 'staff';
                    }
                    header('Location: ?action=home');
                    exit();
                }
            } catch (Exception $e) {
                $error = "Erreur lors de l'inscription: " . $e->getMessage();
            }
        }

        $renderer = new RendererRegister();
        return $renderer->render($error);
    }


}