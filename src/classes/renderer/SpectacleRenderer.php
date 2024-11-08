<?php
namespace iutnc\nrv\renderer;

class SpectacleRenderer {

    public static function renderListeSpectacles(array $spectacles): string {
        $html = "<div class='spectacle-list'>";

        foreach ($spectacles as $spectacle) {
            $html .= "<div class='spectacle-item'>";
            $html .= "<h2>{$spectacle['titre']}</h2>";
            $html .= "<p>Date : {$spectacle['dateSoiree']}</p>";
            $html .= "<p>Horaire : {$spectacle['horrairePrevuSpectacle']}</p>";
            $html .= "<p>Description : {$spectacle['description']}</p>";
            if (!empty($spectacle['urlImage'])) {
                $html .= "<img src='{$spectacle['urlImage']}' alt='Image du spectacle'>";
            }
            $html .= "</div>";
        }

        $html .= "</div>";
        return $html;
    }
}
