<?php
declare(strict_types=1);

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;

require_once 'vendor/autoload.php';

class SpectacleRenderer
{

    protected Spectacle $spectacle;


    public function __construct(Spectacle $piste)
    {
        $this->spectacle = $piste;
    }

    public function render(): string
    {
        return "<p>titre : {$this->spectacle->getTitre()}</p> <p>description : {$this->spectacle->getDescription()}</p> <p>genre : {$this->spectacle->getGenre()}</p> <p>duree : {$this->spectacle->getDureeSpectacle()}</p> <p>video : {$this->spectacle->getUrlVideo()}</p>  <p>horraire : {$this->spectacle->getHorairePrevuSpectacle()}</p> <p>Extrait audio : {$this->spectacle->getUrlAudio()}</p>";
    }
}
