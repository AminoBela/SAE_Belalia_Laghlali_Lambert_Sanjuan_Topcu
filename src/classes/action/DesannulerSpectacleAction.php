<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\auth\Autorisation;


/**
 * Class DesannulerSpectacleAction qui sert a désannuler un spectacle dans le système.
 */
class DesannulerSpectacleAction {

    /**
     * Attribut spectacleRepository
     * @var SpectacleRepository Instance du dépôt des spectacles.
     */
    private SpectacleRepository $spectacleRepository;

    /**
     * Constructeur de la classe DesannulerSpectacleAction
     */
    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }


    /**
     * Exécute l'action de désannulation de spectacle.
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string
    {
        // Ici on verifie si l'utilisateur a les autorisations nécessaires.
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
