<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\SpectacleDetailsRenderer;
use iutnc\nrv\repository\SpectacleRepository;

class SpectacleDetailsAction extends Action
{

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