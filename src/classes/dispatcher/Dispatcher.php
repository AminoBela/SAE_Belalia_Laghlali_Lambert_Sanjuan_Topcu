<?php

namespace iutnc\nrv\dispatcher;

use iutnc\nrv\action\AddSpectacleAction;
use iutnc\nrv\action\AddSoireeAction;
use iutnc\nrv\action\HomeAction;
use iutnc\nrv\action\LoginAction;
use iutnc\nrv\action\RegisterAction;
use iutnc\nrv\action\SpectacleDetailsAction;
use iutnc\nrv\action\SoireeDetailsAction;
use iutnc\nrv\action\AfficherListeSpectaclesAction;

/**
 * Dispatcher pour les actions.
 */
class Dispatcher
{

    /**
     * Attribut pour l'action à effectuer.
     * @var string Action à effectuer.
     */
    private string $action;

    /**
     * Constructeur du dispatcher.
     */
    public function __construct()
    {
        $this->action = "";
        if (isset($_GET['action'])) $this->action = $_GET['action'];
    }

    /**
     * Méthode qui exécute l'action demandée.
     */
    public function run()
    {
        switch ($this->action) {
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
            case 'creerSpectacle':
                $action = new AddSpectacleAction();
                echo $action->execute();
                break;
            case 'creerSoiree':
                $action = new AddSoireeAction();
                echo $action->execute();
                break;
            case 'spectacleDetails':
                $action = new SpectacleDetailsAction();
                echo $action->execute();
                break;
            case 'soireeDetails':
                $action = new SoireeDetailsAction();
                echo $action->execute();
                break;
            case 'afficherListeSpectacles':
                $action = new AfficherListeSpectaclesAction();
                echo $action->execute();
                break;
            default:
                $action = new HomeAction();
                echo $action->execute();
                break;

        }
    }
}