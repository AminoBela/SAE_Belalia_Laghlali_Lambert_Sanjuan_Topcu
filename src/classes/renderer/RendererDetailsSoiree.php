<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Soiree;


class RendererDetailsSoiree extends Renderer
{
    /**
     * @var Soiree Instance de la soirée à rendre.
     */
    private Soiree $soiree;


    public function __construct(Soiree $soiree)
    {
        $this->soiree = $soiree;
    }

    /**
     * Rendu des détails d'une soirée.
     *
     * @param array $contexte Le contexte pour le rendu.
     * @return string Les détails de la soirée rendus sous forme de chaîne de caractères.
     */
    public function render(array $contexte = []): string
    {
        $html = $this->renderHeader("Détails de la Soirée", "styles/soiree.css");

        $html .= "<main class='soiree-details'>";
        $html .= "<h1>" . htmlspecialchars($this->soiree->getNomSoiree(), ENT_QUOTES, 'UTF-8') . "</h1>";
        $html .= "<p><strong>Thématique :</strong> " . htmlspecialchars($this->soiree->getThematique(), ENT_QUOTES, 'UTF-8') . "</p>";
        $html .= "<p><strong>Date :</strong> " . htmlspecialchars($this->soiree->getDateSoiree(), ENT_QUOTES, 'UTF-8') . " à " . htmlspecialchars($this->soiree->getHoraireDebut(), ENT_QUOTES, 'UTF-8') . "</p>";
        $html .= "<p><strong>Lieu :</strong> " . htmlspecialchars($this->soiree->getLieu(), ENT_QUOTES, 'UTF-8') . "</p>";
        $html .= "<p><strong>Tarif :</strong> " . htmlspecialchars($this->soiree->getTarif(), ENT_QUOTES, 'UTF-8') . "</p>";

        $spectacles = $this->soiree->getSpectacles();
        if (!empty($spectacles)) {
            $html .= "<h2>Spectacles Prévus</h2>";
            $html .= "<ul class='spectacles-list'>";

            foreach ($spectacles as $spectacle) {
                $html .= "<li class='spectacle-item'>";
                $html .= "<h3><a href='?action=spectacleDetails&idSpectacle=" . htmlspecialchars($spectacle->getIdSpectacle(), ENT_QUOTES, 'UTF-8') . "'>"
                    . htmlspecialchars($spectacle->getTitre(), ENT_QUOTES, 'UTF-8') . "</a></h3>";
                $html .= "<p>" . htmlspecialchars($spectacle->getDescription(), ENT_QUOTES, 'UTF-8') . "</p>";
                $html .= "<p><strong>Genre :</strong> " . htmlspecialchars($spectacle->getGenre(), ENT_QUOTES, 'UTF-8') . "</p>";
                $html .= "<p><strong>Horaire :</strong> " . htmlspecialchars($spectacle->getHorairePrevuSpectacle(), ENT_QUOTES, 'UTF-8') . "</p>";
                $html .= "</li>";
            }

            $html .= "</ul>";
        } else {
            $html .= "<p>Aucun spectacle prévu pour cette soirée.</p>";
        }

        $html .= "</main>";
        $html .= $this->renderFooter();

        return $html;
    }
}
