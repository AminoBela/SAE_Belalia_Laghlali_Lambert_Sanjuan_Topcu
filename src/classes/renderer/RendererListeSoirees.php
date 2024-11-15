<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererListeSoirees
 *
 * Classe pour rendre la liste des soirées.
 *
 * @package iutnc\nrv\renderer
 */
class RendererListeSoirees extends Renderer
{
    /**
     * Rendu de la liste des soirées.
     *
     * @param array $contexte Le contexte contenant les données nécessaires pour le rendu.
     * @return string La liste des soirées rendue sous forme de chaîne de caractères.
     */
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
            $html .= '<a class="voir-plus-button" href="?action=soireeDetails&idLieu=' . htmlspecialchars($soiree->getLieu()->getIdLieu(), ENT_QUOTES, 'UTF-8') . '&dateSoiree=' . htmlspecialchars($soiree->getDateSoiree(), ENT_QUOTES, 'UTF-8') . '">Voir plus</a>';
            $html .= '</div>';
        }
        $html .= '</div>';

        $html .= $this->renderFooter();
        return $html;
    }
}
