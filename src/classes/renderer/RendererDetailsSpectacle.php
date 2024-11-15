<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\auth\Autorisation;

/**
 * Class RendererDetailsSpectacle
 *
 * Classe pour rendre les détails d'un spectacle.
 *
 * @package iutnc\nrv\renderer
 */
class RendererDetailsSpectacle extends Renderer
{
    /**
     * @var Spectacle Instance du spectacle à rendre.
     */
    private Spectacle $spectacle;

    /**
     * RendererDetailsSpectacle constructor.
     *
     * @param Spectacle $spectacle L'instance du spectacle à rendre.
     */
    public function __construct(Spectacle $spectacle)
    {
        $this->spectacle = $spectacle;
    }

    /**
     * Rendu des détails d'un spectacle.
     *
     * @param array $contexte Le contexte pour le rendu.
     * @return string Les détails du spectacle rendus sous forme de chaîne de caractères.
     */
    public function render(array $contexte = []): string
    {
        $statusAnnulation = $this->spectacle->getEstAnnule()
            ? "<p class='status-annule'>⚠️ Ce spectacle est annulé</p>"
            : "";

        $dureeSpectacle = $this->spectacle->getEstAnnule()
            ? "<span class='annule'>Spectacle annulé</span>"
            : htmlspecialchars($this->spectacle->getDureeSpectacleText(), ENT_QUOTES, 'UTF-8');

        $audio = $this->spectacle->getUrlAudio();
        $audioElement = $audio ? "
            <audio controls>
                <source src='" . htmlspecialchars($audio, ENT_QUOTES, 'UTF-8') . "' type='audio/mpeg'>
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        " : "";

        $video = $this->spectacle->getUrlVideo();
        $videoElement = "";
        if ($video) {
            if (strpos($video, 'youtube') !== false) {
                $youtubeId = explode('=', $video);
                $video = "https://www.youtube.com/embed/" . end($youtubeId);
                $videoElement = "
                    <iframe width='560' height='315' src='" . htmlspecialchars($video, ENT_QUOTES, 'UTF-8') . "' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                ";
            } else {
                $videoElement = "
                    <video controls>
                        <source src='" . htmlspecialchars($video, ENT_QUOTES, 'UTF-8') . "' type='video/mp4'>
                        Votre navigateur ne supporte pas l'élément vidéo.
                    </video>
                ";
            }
        }

        $images = $this->spectacle->getImages();
        $imagesElement = "";
        if (!empty($images)) {
            $imagesElement = "<div class='images-container'>";
            foreach ($images as $image) {
                if (!empty($image)) {
                    $imagesElement .= "<img src='uploads/images/" . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "' alt='Image du spectacle'>";
                }
            }
            $imagesElement .= "</div>";
        }



        $cancelButton = "";
        if (Autorisation::isStaff() || Autorisation::isAdmin()) {
            $cancelButton = "
                <form action='?action=annulerSpectacle' method='post'>
                    <input type='hidden' name='idSpectacle' value='" . htmlspecialchars($this->spectacle->getIdSpectacle(), ENT_QUOTES, 'UTF-8') . "'>
                    <button type='submit' class='btn-annulation'>Annuler le spectacle</button>
                </form>
            ";
        }

        return $this->renderHeader($this->spectacle->getTitre(), 'styles/spectacle-details.css') . <<<HTML
            <div class="details-header">
                <div class="image-container">
                    <img src="uploads/images/{$this->spectacle->getImagePrincipale()}" alt="Image du spectacle">
                    <div class="image-text">
                        <h1>{$this->spectacle->getTitre()}</h1>
                    </div>
                </div>
                {$statusAnnulation}
                <p>{$this->spectacle->getDescription()}</p>
                {$videoElement}
                {$audioElement}
                {$cancelButton}
            </div>
            <div class="details-body">
                <p><span>Genre :</span> {$this->spectacle->getGenre()}</p>
                <p><span>Horaire prévu :</span> {$this->spectacle->getHorairePrevuSpectacleText()}</p>
                <p><span>Durée :</span> {$dureeSpectacle}</p>
                <div class="image-final">{$imagesElement}</div>
            </div>
HTML
            . $this->renderFooter();
    }
}
