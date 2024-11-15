<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\renderer\RendererListeSoirees;

/**
 * Class AfficherListeSoireesAction
 *
 * Action pour afficher la liste des soirées dans le système.
 *
 * @package iutnc\nrv\action
 */
class AfficherListeSoireesAction extends Action
{
    /**
     * @var SoireeRepository Instance du dépôt des soirées.
     */
    private SoireeRepository $soireeRepository;

    /**
     * AfficherListeSoireesAction constructor.
     */
    public function __construct() {
        $this->soireeRepository = new SoireeRepository();
    }

    /**
     * Exécute l'action d'affichage de la liste des soirées.
     *
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string {
        // Récupère la liste des soirées depuis le dépôt.
        $soirees = $this->soireeRepository->getListeSoirees();

        // Crée une instance du renderer pour afficher la liste des soirées.
        $renderer = new RendererListeSoirees();
        return $renderer->render([
            'soirees' => $soirees
        ]);
    }
}
