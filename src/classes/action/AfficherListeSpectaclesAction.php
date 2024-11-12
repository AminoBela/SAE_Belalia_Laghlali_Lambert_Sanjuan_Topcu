<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\RendererListeSpectacles;

class AfficherListeSpectaclesAction extends Action {

    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        // Récupérer le paramètre de tri, avec 'date' comme valeur par défaut
        $sort = $_GET['sort'] ?? 'date';

        // Appel à la méthode de tri en fonction du paramètre
        if ($sort === 'genre') {
            $spectacles = $this->spectacleRepository->getListeSpectaclesByGenre();
        } elseif ($sort === 'lieu') {
            $spectacles = $this->spectacleRepository->getListeSpectaclesByLieu();
        } else {
            $spectacles = $this->spectacleRepository->getListeSpectaclesByDate();
        }

        $renderer = new RendererListeSpectacles();
        return $renderer->renderListeSpectacles($spectacles);
    }

}
