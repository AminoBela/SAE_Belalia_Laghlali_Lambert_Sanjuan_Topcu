<?php
declare(strict_types=1);

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Soiree;

/**
 * Renderer pour les détails d'une soirée.
 */
class RendererSoiree
{

    /**
     * La soirée à afficher.
     * @var Soiree La soirée à afficher.
     */
    protected Soiree $soiree;


    /**
     * Constructeur.
     * @param Soiree $soiree La soirée à afficher.
     */
    public function __construct(Soiree $piste)
    {
        $this->soiree = $piste;
    }

    /**
     * Rendu de la soirée.
     * @return string
     */
    public function render(): string
    {
        return "<p>nom : {$this->soiree->getNomSoiree()}</p> <p>date : {$this->soiree->getDateSoiree()}</p> <p>thématique : {$this->soiree->getThematique()}</p> <p>début : {$this->soiree->getHoraireDebut()}</p> <p>lieu : {$this->soiree->getLieu()}</p>";
    }
}
