<?php
namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\SpectacleRenderer;

class ListeSpectacles {

    public function execute(): string {
        $repo = new SpectacleRepository();
        $spectacles = $repo->getListeSpectacles();

        return SpectacleRenderer::renderListeSpectacles($spectacles);
    }
}
