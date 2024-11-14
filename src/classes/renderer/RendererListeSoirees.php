<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Soiree;

class RendererListeSoirees extends Renderer
{
    public function render(array $contexte = []): string
    {
        $soirees = $contexte['soirees'];
        $html = $this->renderHeader('Liste des soirées', 'styles/soiree.css');

        $html .= '<div class="soiree-list">';
        foreach ($soirees as $soiree) {
            $html .= '<div class="soiree-item">';
            $html .= '<h2>' . htmlspecialchars($soiree->getNomSoiree(), ENT_QUOTES, 'UTF-8') . '</h2>';
            $html .= '<p>' . htmlspecialchars($soiree->getThematique(), ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Date: ' . htmlspecialchars($soiree->getDateSoiree(), ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Lieu: ' . htmlspecialchars($soiree->getLieu()->getNomLieu(), ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<a class="voir-plus-button" href="?action=soireeDetails&idLieu=' . $soiree->getLieu()->getIdLieu() . '&dateSoiree=' . $soiree->getDateSoiree() . '">Voir plus</a>';
            $html .= '</div>';
        }
        $html .= '</div>';

        $html .= $this->renderFooter();
        return $html;
    }
}