<?php

namespace iutnc\nrv\action;

use iutnc\nrv\action\Action;
use iutnc\nrv\renderer\RendererListePreferences;
use iutnc\nrv\renderer\RendererListeSpectacles;
use iutnc\nrv\repository\PreferencesRepository;
use iutnc\nrv\repository\SpectacleRepository;

/**
 * Action permettant d'afficher les préférences de l'utilisateur.
 */
class AfficherPreferencesAction extends Action
{
    /*
     * @var SpectacleRepository Repository des spectacles.
     */
    private SpectacleRepository $soireeRepository;

    /*
     * Constructeur de l'action.
     */
    public function __construct()
    {
        parent::__construct();
        $this->soireeRepository = new SpectacleRepository();
    }


    /**
     * Exécute l'action (affiche les préférences de l'utilisateur).
     * @return string Code HTML de la page des préférences.
     */
    public function execute(): string
    {
        // Récupérer les identifiants des spectacles préférés
        $idSpectacles = PreferencesRepository::getInstance()->getSpectaclesIdsPref();

        // Récupérer les spectacles correspondants depuis la base de données
        $spectacles = $this->soireeRepository->getPreferencesSpectacles($idSpectacles);

        // Rendre la page des préférences
        $renderer = new RendererListePreferences();
        return $renderer->render([
            'spectacles' => $spectacles
        ]);
    }
}