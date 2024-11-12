<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;

class SpectacleDetailsRenderer extends Renderer
{
    private Spectacle $spectacle;

    public function __construct(Spectacle $spectacle)
    {
        $this->spectacle = $spectacle;
    }

    public function render(array $context = []): string
    {
        // Gestion de la durée ou annulation
        $dureeSpectacle = $this->spectacle->getEstAnnule()
            ? "<span class='annule'>Spectacle annulé</span>"
            : "Durée du spectacle : " . $this->spectacle->getDureeSpectacleText();

        // Gestion de l'audio
        $audio = $this->spectacle->getUrlAudio();
        $audioElement = $audio ? "
            <audio controls>
                <source src='{$audio}' type='audio/mpeg'>
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        " : "";

        // Gestion de la vidéo
        $video = $this->spectacle->getUrlVideo();
        $videoElement = "";
        if ($video) {
            if (strpos($video, 'youtube') !== false) {
                $youtubeId = explode('=', $video);
                $video = "https://www.youtube.com/embed/" . end($youtubeId);
                $videoElement = "
                    <iframe width='560' height='315' src='{$video}' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                ";
            } else {
                $videoElement = "
                    <video controls>
                        <source src='{$video}' type='video/mp4'>
                        Votre navigateur ne supporte pas l'élément vidéo.
                    </video>
                ";
            }
        }

        // Gestion des images
        $urlImage = $this->spectacle->getImages();
        $imageSrc = is_array($urlImage) && !empty($urlImage) ? $urlImage[0] : 'default-image.jpg';

        // Construction du rendu HTML
        return $this->renderHeader($this->spectacle->getTitre(), 'styles/spectacle-details.css') . <<<HTML
            <div class="details-header">
                <div class="image-container">
                    <img src="{$imageSrc}" alt="Image du spectacle">
                    <div class="image-text">
                        <h1>{$this->spectacle->getTitre()}</h1>
                    </div>
                </div>
                <p>{$this->spectacle->getDescription()}</p>
                {$videoElement}
                {$audioElement}
            </div>
            <div class="details-body">
                <p><span>Genre :</span> {$this->spectacle->getGenre()}</p>
                <p><span>Horaire prévu :</span> {$this->spectacle->getHorairePrevuSpectacle()}</p>
                <p><span>Durée :</span> {$dureeSpectacle}</p>
            </div>
            HTML
            . $this->renderFooter();
    }
}
