<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererHome;

/**
 * Action pour la page d'accueil.
 */
class HomeAction extends Action
{

    /**
     * Exécute l'action.
     * @return string
     */
    public function execute(): string
    {
        $renderer = new RendererHome();
        return $renderer->render();
    }
}