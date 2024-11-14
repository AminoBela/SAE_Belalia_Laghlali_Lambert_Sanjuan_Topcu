<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class AnnulerSpectacleAction {
    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        $idSpectacle = filter_input(INPUT_POST, 'idSpectacle', FILTER_VALIDATE_INT);
        if ($idSpectacle === false) {
            return "ID de spectacle invalide.";
        }

        $success = $this->spectacleRepository->annulerSpectacle($idSpectacle);
        return $success ? "Spectacle annulé avec succès." : "Erreur lors de l'annulation du spectacle.";
    }
}