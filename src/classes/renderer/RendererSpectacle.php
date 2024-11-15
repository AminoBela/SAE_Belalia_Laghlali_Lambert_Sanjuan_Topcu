<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;

class RendererSpectacle extends Renderer
{
    private array $spectacle;

    public function __construct(array $spectacle)
    {
        $this->spectacle = $spectacle;
    }


    public function render(array $contexte = []): string
    {
        $spectacle = $this->spectacle;

        $titre = htmlspecialchars($spectacle['titre'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($spectacle['dateSoiree'], ENT_QUOTES, 'UTF-8');
        $horaire = htmlspecialchars($spectacle['horrairePrevuSpectacle'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
        $style = htmlspecialchars($spectacle['genre'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
        $lieu = htmlspecialchars($spectacle['nomLieu'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($spectacle['description'], ENT_QUOTES, 'UTF-8');
        $urlImage = htmlspecialchars($spectacle['urlImage'] ?? '', ENT_QUOTES, 'UTF-8');
        $idSpectacle = htmlspecialchars($spectacle['idSpectacle'], ENT_QUOTES, 'UTF-8');

        $html = "<div class='spectacle-item'>";
        $html .= "<div class='like'>";
        $html .= "<h2>{$titre}</h2>";
        $html .= LikeButton::renderLikeButton($idSpectacle, 25,  $contexte['chemin'] ?? "afficherListeSpectacles");
        $html .= "</div>";
        $html .= "<p>Date : {$date}</p>";
        $html .= "<p>Horaire : {$horaire}</p>";
        $html .= "<p>Style de musique : {$style}</p>";
        $html .= "<p>Lieu : {$lieu}</p>";
        $html .= "<p>Description : {$description}</p>";

        if (!empty($urlImage)) {
            $html .= "<img src='uploads/images/{$urlImage}' alt='Image du spectacle' class='image-spectacle-liste'>";
        } else {
            $html .= "<img src='uploads/images/default.jpg' alt='Image du spectacle' class='image-spectacle-liste'>";
        }

        $html .= "<a href='?action=spectacleDetails&idSpectacle={$idSpectacle}'>Voir plus</a>";
        $html .= "</div>";

        return $html;
    }
}