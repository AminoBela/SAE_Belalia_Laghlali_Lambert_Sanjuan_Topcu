<?php
declare(strict_types=1);

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Soiree;

require_once 'vendor/autoload.php';

class SoireeRenderer
{

    protected Soiree $soiree;


    public function __construct(Soiree $piste)
    {
        $this->soiree = $piste;
    }

    public function render(): string
    {
        return "<p>nom : {$this->soiree->getNomSoiree()}</p> <p>date : {$this->soiree->getDateSoiree()}</p> <p>thématique : {$this->soiree->getThematique()}</p> <p>début : {$this->soiree->getHoraireDebut()}</p> <p>lieu : {$this->soiree->getLieu()}</p>";
    }
}
