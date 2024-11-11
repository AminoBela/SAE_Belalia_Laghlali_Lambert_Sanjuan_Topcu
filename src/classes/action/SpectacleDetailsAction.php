<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\SpectacleDetailsRenderer;
use iutnc\nrv\repository\SpectacleRepository;

/**
 * Action pour la page de détails d'un spectacle. Fonctionnalite 5.
 */
class SpectacleDetailsAction extends Action
{

    /**
     * Exécute l'action.
     * @return string
     */
    public function execute(): string
    {
        $spectacleRep = new SpectacleRepository();
        $spectacle = $spectacleRep->obtenirSpectacleParId($_GET['idSpectacle']);

        if ($spectacle !=  null) {
            return (new SpectacleDetailsRenderer($spectacle))->render();
        } else {
            return "<p>Spectacle introuvable.</p>";
        }
    }
}