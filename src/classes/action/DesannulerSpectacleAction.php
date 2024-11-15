<?php

namespace iutnc\nrv\action;

use iutnc\nrv\bd\SpectacleRepository;

class DesannulerSpectacleAction {
    private SpectacleRepository $spectacleRepository;

    public function __construct(SpectacleRepository $spectacleRepository) {
        $this->spectacleRepository = $spectacleRepository;
    }


    public function execute(int $idSpectacle): string {
        $success = $this->spectacleRepository->desannulerSpectacle($idSpectacle);
        return $success ? "Spectacle désannulé avec succès." : "Erreur lors de la désannulation du spectacle.";
    }
}
