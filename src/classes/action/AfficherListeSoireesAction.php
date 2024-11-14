<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\renderer\RendererHome;

/**
 * Classe d'action pour afficher la liste des soirées dans le home.
 */
class AfficherListeSoireesAction extends Action
{
    private SoireeRepository $soireeRepository;

    public function __construct() {
        $this->soireeRepository = new SoireeRepository();
    }

    public function execute(): string {
        $soirees = $this->soireeRepository->getListeSoirees();
        $renderer = new RendererHome();
        return $renderer->render([
            'soirees' => $soirees
        ]);
    }
}