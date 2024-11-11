<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\RendererListeSpectacles;

class AfficherListeSpectaclesAction extends Action
{

    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        $spectacles = $this->spectacleRepository->getListeSpectacles();
        $renderer = new RendererListeSpectacles();
        return $renderer->renderListeSpectacles($spectacles);
    }

}