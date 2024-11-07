<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;

class LoginAction
{
    private Authentification $auth;

    public function __construct()
    {
        $this->auth = new Authentification();
        session_start();
    }

    public function execute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            try {
                if ($this->auth->login($email, $password)) {
                    $_SESSION['email'] = $email;
                }
            }
        }
    }

}