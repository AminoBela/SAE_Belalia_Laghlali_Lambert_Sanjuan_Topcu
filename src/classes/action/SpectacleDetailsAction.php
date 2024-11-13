<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererDetailsSpectacle;
use iutnc\nrv\repository\SpectacleRepository;

class SpectacleDetailsAction extends Action
{
    public function execute(): string
    {
        $spectacleRep = new SpectacleRepository();
        $spectacle = $spectacleRep->obtenirSpectacleParId(filter_var($_GET['idSpectacle'], FILTER_SANITIZE_STRING));

        if ($spectacle !=  null) {
            return (new RendererDetailsSpectacle($spectacle))->render();
        } else {
            return "<p>Spectacle introuvable.</p>";
        }
    }
}