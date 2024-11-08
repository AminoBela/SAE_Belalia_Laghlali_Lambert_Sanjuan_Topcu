<?php

namespace iutnc\nrv\dispatcher;

use iutnc\nrv\action\HomeAction;
use iutnc\nrv\action\LoginAction;
use iutnc\nrv\action\RegisterAction;

class Dispatcher
{
    private string $action;

    public function __construct()
    {
        $this->action = "";
        if (isset($_GET['action'])) $this->action = $_GET['action'];
    }

    public function run()
    {
        switch ($this->action) {
            default:
                $action = new HomeAction();
                echo $action->execute();
                break;
            case 'login':
                $action = new LoginAction();
                echo $action->execute();
                break;
            case 'register':
                $action = new RegisterAction();
                echo $action->execute();
                break;
            case 'logout':
                session_destroy();
                header('Location: ?action=home');
                break;
        }
    }
}