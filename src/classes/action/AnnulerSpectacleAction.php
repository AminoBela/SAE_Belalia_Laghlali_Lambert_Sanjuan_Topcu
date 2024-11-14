<?php

namespace iutnc\nrv\action;

use iutnc\nrv\bd\SpectacleRepository;

class AnnulerSpectacleAction {
    private SpectacleRepository $spectacleRepository;

    public function __construct(SpectacleRepository $spectacleRepository) {
        $this->spectacleRepository = $spectacleRepository;
    }

    public function execute(int $idSpectacle): string {
        $success = $this->spectacleRepository->annulerSpectacle($idSpectacle);
        return $success ? "Spectacle annulé avec succès." : "Erreur lors de l'annulation du spectacle.";
    }
}
