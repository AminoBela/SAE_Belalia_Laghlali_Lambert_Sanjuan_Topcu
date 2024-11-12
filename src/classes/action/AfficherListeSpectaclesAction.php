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
        $filterCriteria = filter_input(INPUT_GET, 'filter-criteria', FILTER_SANITIZE_STRING);
        $filterOption = filter_input(INPUT_GET, 'filter-options', FILTER_SANITIZE_STRING);

        $spectacles = [];
        if ($filterCriteria && $filterOption) {
            switch ($filterCriteria) {
                case 'jour':
                    $spectacles = $this->spectacleRepository->getListeSpectaclesByDate($filterOption);
                    break;
                case 'lieu':
                    $spectacles = $this->spectacleRepository->getListeSpectaclesByLieu($filterOption);
                    break;
                case 'style':
                    $spectacles = $this->spectacleRepository->getListeSpectaclesByGenre($filterOption);
                    break;
            }
        } else {
            $spectacles = $this->spectacleRepository->getListeSpectacles();
        }

        $jours = $this->spectacleRepository->getDistinctJours();
        $lieux = $this->spectacleRepository->getDistinctLieux();
        $styles = $this->spectacleRepository->getDistinctStyles();

        $renderer = new RendererListeSpectacles();
        return $renderer->render([
            'spectacles' => $spectacles,
            'jours' => $jours,
            'lieux' => $lieux,
            'styles' => $styles,
            'selectedCriteria' => $filterCriteria,
            'selectedOption' => $filterOption
        ]);
    }
}