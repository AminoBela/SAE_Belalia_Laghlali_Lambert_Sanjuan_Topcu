<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\RendererListeSpectacles;

/**
 * Class AfficherListeSpectaclesAction
 *
 * Action pour afficher la liste des spectacles dans le système.
 *
 * @package iutnc\nrv\action
 */
class AfficherListeSpectaclesAction extends Action
{
    /**
     * @var SpectacleRepository Instance du dépôt des spectacles.
     */
    private SpectacleRepository $spectacleRepository;

    /**
     * AfficherListeSpectaclesAction constructor.
     */
    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    /**
     * Exécute l'action d'affichage de la liste des spectacles.
     *
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string {
        // Récupère les critères de filtrage depuis les paramètres GET.
        $filterCriteria = filter_input(INPUT_GET, 'filter-criteria', FILTER_SANITIZE_STRING);
        $filterOption = filter_input(INPUT_GET, 'filter-options', FILTER_SANITIZE_STRING);

        $spectacles = [];
        if ($filterCriteria && $filterOption) {
            // Filtrage des spectacles selon les critères sélectionnés.
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
            // Récupère tous les spectacles si aucun critère de filtrage n'est fourni.
            $spectacles = $this->spectacleRepository->getListeSpectacles();
        }

        // Récupère les valeurs distinctes pour les critères de filtrage.
        $jours = $this->spectacleRepository->getDistinctJours();
        $lieux = $this->spectacleRepository->getDistinctLieux();
        $styles = $this->spectacleRepository->getDistinctStyles();

        // Crée une instance du renderer pour afficher la liste des spectacles.
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
