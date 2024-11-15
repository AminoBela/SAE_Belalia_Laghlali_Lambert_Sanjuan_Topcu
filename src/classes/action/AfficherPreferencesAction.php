<?php

namespace iutnc\nrv\action;

use iutnc\nrv\action\Action;
use iutnc\nrv\renderer\RendererListePreferences;
use iutnc\nrv\renderer\RendererListeSpectacles;
use iutnc\nrv\repository\PreferencesRepository;
use iutnc\nrv\repository\SpectacleRepository;

class AfficherPreferencesAction extends Action
{
    private SpectacleRepository $soireeRepository;

    public function __construct()
    {
        $this->soireeRepository = new SpectacleRepository();
    }


    public function execute(): string
    {
        $idSpectacles = PreferencesRepository::getInstance()->getSpectaclesIdsPref();

        $spectacles = $this->soireeRepository->getPreferencesSpectacles($idSpectacles);

        $renderer = new RendererListePreferences();
        return $renderer->render([
            'spectacles' => $spectacles
        ]);
    }
}