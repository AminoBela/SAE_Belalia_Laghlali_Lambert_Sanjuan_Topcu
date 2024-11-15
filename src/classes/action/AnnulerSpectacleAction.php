<?php

namespace iutnc\nrv\action;

use iutnc\nrv\auth\Authentification;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\repository\SpectacleRepository;

/**
 * Class AnnulerSpectacleAction
 *
 * Action pour annuler un spectacle dans le système.
 *
 * @package iutnc\nrv\action
 */
class AnnulerSpectacleAction {
    /**
     * @var SpectacleRepository Instance du dépôt des spectacles.
     */
    private SpectacleRepository $spectacleRepository;

    /**
     * AnnulerSpectacleAction constructor.
     */
    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    /**
     * Exécute l'action d'annulation de spectacle.
     *
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string {
        // Vérifie si l'utilisateur a les autorisations nécessaires.
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        // Récupère l'ID du spectacle depuis le formulaire POST.
        $idSpectacle = filter_input(INPUT_POST, 'idSpectacle', FILTER_VALIDATE_INT);
        if ($idSpectacle === false) {
            return "ID de spectacle invalide.";
        }

        // Annule le spectacle en utilisant le dépôt.
        $success = $this->spectacleRepository->annulerSpectacle($idSpectacle);
        return $success ? "Spectacle annulé avec succès." : "Erreur lors de l'annulation du spectacle.";
    }
}
