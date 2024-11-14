<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererDetailsSpectacle;
use iutnc\nrv\repository\SpectacleRepository;

class SpectacleDetailsAction extends Action
{
    public function execute(): string
    {
        $spectacleRep = new SpectacleRepository();
        $spectacle = $spectacleRep->obtenirSpectacleParId(htmlspecialchars($_GET['idSpectacle'], ENT_QUOTES, 'UTF-8'));

        if ($spectacle !=  null) {
            return (new RendererDetailsSpectacle($spectacle))->render();
        } else {
            return "<p>Spectacle introuvable.</p>";
        }
    }
}