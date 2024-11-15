<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Spectacle;

/**
 * Rendu d'un spectacle.
 */
class RendererSpectacle extends Renderer
{
    /**
     * Spectacle à afficher.
     * @var array Données du spectacle.
     */
    private array $spectacle;

    /*
     * Constructeur (les données du spectacle sont passées en paramètre).
     */
    public function __construct(array $spectacle)
    {
        $this->spectacle = $spectacle;
    }

    /**
     * Rendu du spectacle.
     * @param array $contexte Contexte de rendu (utilisé par une classe pour indiqué le chemin quand on clique sur le like).
     * @return string Code HTML du spectacle.
     */
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
        // Ajout du bouton like (avec le chemin à recharger en cas de like)
        $html .= LikeButton::renderLikeButton($idSpectacle, 25,  $contexte['chemin'] ?? "afficherListeSpectacles");
        $html .= "</div>";
        $html .= "<p>Date : {$date}</p>";
        $html .= "<p>Horaire : {$horaire}</p>";
        $html .= "<p>Style de musique : {$style}</p>";
        $html .= "<p>Lieu : {$lieu}</p>";
        $html .= "<p>Description : {$description}</p>";

        // Si l'image existe, on l'affiche, sinon on affiche une image par défaut
        if (!empty($urlImage)) {
            $html .= "<img src='uploads/images/{$urlImage}' alt='Image du spectacle' class='image-spectacle-liste'>";
        } else {
            $html .= "<img src='uploads/images/default.jpg' alt='Image du spectacle' class='image-spectacle-liste'>";
        }

        // Lien pour voir plus de détails sur le spectacle
        $html .= "<a href='?action=spectacleDetails&idSpectacle={$idSpectacle}'>Voir plus</a>";
        $html .= "</div>";

        return $html;
    }
}