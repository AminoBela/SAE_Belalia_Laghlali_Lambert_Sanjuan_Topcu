<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\auth\Autorisation;


class DesannulerSpectacleAction {
    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }


    public function execute(): string
    {
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }
        // Récupère l'ID du spectacle depuis le formulaire POST.
        $idSpectacle = filter_input(INPUT_POST, 'idSpectacle', FILTER_VALIDATE_INT);
        if ($idSpectacle === false) {
            return "ID de spectacle invalide.";
        }

        $success = $this->spectacleRepository->desannulerSpectacle($idSpectacle);
        return $success ? "Spectacle désannulé avec succès." : "Erreur lors de la désannulation du spectacle.";

    }
}
