<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\renderer\RendererListeSoirees;

class AfficherListeSoireesAction extends Action
{
    private SoireeRepository $soireeRepository;

    public function __construct() {
        $this->soireeRepository = new SoireeRepository();
    }

    public function execute(): string {
        $soirees = $this->soireeRepository->getListeSoirees();
        $renderer = new RendererListeSoirees();
        return $renderer->render([
            'soirees' => $soirees
        ]);
    }
}