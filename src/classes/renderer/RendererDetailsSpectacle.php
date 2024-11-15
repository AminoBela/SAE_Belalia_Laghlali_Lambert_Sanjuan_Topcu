<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\auth\Autorisation;

class RendererDetailsSpectacle extends Renderer
{
    private Spectacle $spectacle;

    public function __construct(Spectacle $spectacle)
    {
        $this->spectacle = $spectacle;
    }

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

        $artistes = $this->spectacle->getArtistes();
        $artistesElement = "";
        if (!empty($artistes)) {
            $artistesElement = "<p><span>Artistes :</span> ";
            foreach ($artistes as $artiste) {
                $artistesElement .= htmlspecialchars($artiste->getNomArtiste(), ENT_QUOTES, 'UTF-8') . ", ";
            }
            $artistesElement = rtrim($artistesElement, ', ') . "</p>";
        }

        $cancelButton = "";
        if (Autorisation::isStaff() || Autorisation::isAdmin()) {
            $cancelButton = "
                <form action='?action=annulerSpectacle' method='post'>
                    <input type='hidden' name='idSpectacle' value='{$this->spectacle->getIdSpectacle()}'>
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
                <p><span>Horaire prévu :</span> {$this->spectacle->getHorairePrevuSpectacle()}</p>
                <p><span>Durée :</span> {$dureeSpectacle}</p>
                {$artistesElement}
                <div class="image-final">{$imagesElement}</div>
            </div>
            HTML
            . $this->renderFooter();
    }
}