<?php

namespace iutnc\nrv\renderer;

class RendererListeSpectacles extends Renderer {

    public function renderListeSpectacles(array $spectacles): string {

        $header = $this->renderHeader('Liste des spectacles - NRV Festival');
        $footer = $this->renderFooter();

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
            $html .= "<a href='?action=spectacleDetails&idSpectacle={$spectacle['idSpectacle']}'>Voir plus</a>";
            $html .= "</div>";
        }

        $html .= "</div>";
        return $header . $html . $footer;
    }

    public function render(array $context = []): string {
        return $this->renderListeSpectacles($context);
    }
}