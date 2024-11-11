<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;
use iutnc\nrv\renderer\RendererDetailsSoiree;
use iutnc\nrv\repository\SoireeRepository;

class SoireeDetailsAction extends Action
{
    public function execute(): string
    {
        $idLieu = $_GET['idLieu'] ?? null;
        $dateSoiree = $_GET['dateSoiree'] ?? null;

        if (!$idLieu || !$dateSoiree) {
            return "<p>ID du lieu ou date de la soirée manquants.</p>";
        }

        $soireeRepository = new SoireeRepository();
        $soiree = $soireeRepository->getSoireeById((int) $idLieu, $dateSoiree);

        if (!$soiree) {
            return "<p>Soirée introuvable.</p>";
        }

        // Récupération des spectacles associés à la soirée
        $spectacles = $soireeRepository->getSpectaclesForSoiree((int) $idLieu, $dateSoiree);

        // Ajout des spectacles à l'objet Soiree
        $soiree->setSpectacles($spectacles);

        // Renderer
        $renderer = new RendererDetailsSoiree($soiree);
        return $renderer->render();
    }

}
