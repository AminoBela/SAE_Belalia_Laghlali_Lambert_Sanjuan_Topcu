<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererDetailsSoiree;
use iutnc\nrv\repository\SoireeRepository;

/**
 * Action pour la page de détails d'une soirée. Fonctionnalité 6.
 */
class SoireeDetailsAction extends Action
{

    /**
     * Exécute l'action.
     * @return string
     */
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

        $spectacles = $soireeRepository->getSpectaclesForSoiree((int) $idLieu, $dateSoiree);

        $soiree->setSpectacles($spectacles);

        $renderer = new RendererDetailsSoiree($soiree);
        return $renderer->render();
    }

}
