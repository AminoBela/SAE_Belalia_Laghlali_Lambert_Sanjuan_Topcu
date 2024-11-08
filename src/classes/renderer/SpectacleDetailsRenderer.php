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
        // si le spectacle est annulé, on affiche un message, sinon affiche la durée du spectacle
        $dureeSpectacle = $this->spectacle->getEstAnnule() ? "Spectacle annulé" : "Durée du spectacle : " . $this->spectacle->getDureeSpectacle();

        // affiche l'audio avec le titre du spectacle, sa description, la vidéo si elle existe
        // et les autres informations du spectacle
        $audio = $this->spectacle->getUrlAudio() ?? "";
        $video = $this->spectacle->getUrlVideo() ?? "";

        if ($audio) {
            $audioElement = "<audio controls>
                                <source src='$audio' type='audio/mpeg'>
                                Your browser does not support the audio element.
                            </audio>";
        } else {
            $audioElement = "";
        }

        if ($video) {
            if (strpos($video, 'youtube') !== false) {
                // obtient l'id de la vidéo youtube
                $youtubeId = explode('=', $video);

                // crée le lien de la vidéo youtube avec embed
                $video = "https://www.youtube.com/embed/" . end($youtubeId);

                // crée l'iframe de la vidéo youtube
                $videoElement = "<iframe width='560' height='315' src='$video' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
            } else {
                $videoElement = "<video controls>
                                    <source src='$video' type='video/mp4'>
                                    Your browser does not support the video element.
                                </video>";
            }
        } else {
            $videoElement = "";
        }

        return
            $this->renderHeader($this->spectacle->getTitre(), 'spectacle-details.css') .
            "
            <div class='spectacle-details'>
                <div class='details-header'>
                    <div class='no-row'>
                        <p>$dureeSpectacle</p>
                        <h1>{$this->spectacle->getTitre()}</h1>
                        <p>{$this->spectacle->getDescription()}</p>
                    </div>
                    $videoElement
                    $audioElement
                </div>
                <div class='details-body'>
                    <p>Genre : {$this->spectacle->getGenre()}</p>
                    <p>Horaire prévu : {$this->spectacle->getHorairePrevuSpectacle()}</p>
                </div>
            </div>
            "
            . $this->renderFooter();
    }
}