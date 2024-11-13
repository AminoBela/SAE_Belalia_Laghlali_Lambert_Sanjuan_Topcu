<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;

class RendererDetailsSoiree extends Renderer
{
    private Soiree $soiree;

    public function __construct(Soiree $soiree)
    {
        $this->soiree = $soiree;
    }

    public function render(array $contexte = []): string
    {
        // Header
        $html = $this->renderHeader("Détails de la Soirée", "styles/soiree.css");

        // Contenu principal
        $html .= "<main class='soiree-details'>";
        $html .= "<h1>" . htmlspecialchars($this->soiree->getNomSoiree()) . "</h1>";
        $html .= "<p><strong>Thématique :</strong> " . htmlspecialchars($this->soiree->getThematique()) . "</p>";
        $html .= "<p><strong>Date :</strong> " . htmlspecialchars($this->soiree->getDateSoiree()) . " à " . htmlspecialchars($this->soiree->getHoraireDebut()) . "</p>";
        $html .= "<p><strong>Lieu :</strong> " . htmlspecialchars($this->soiree->getLieu()) . "</p>";

        $spectacles = $this->soiree->getSpectacles();
        if (!empty($spectacles)) {
            $html .= "<h2>Spectacles Prévus</h2>";
            $html .= "<ul class='spectacles-list'>";

            foreach ($spectacles as $spectacle) {
                $html .= "<li class='spectacle-item'>";
                $html .= "<h3><a href='?action=spectacleDetails&idSpectacle=" . htmlspecialchars($spectacle->getIdSpectacle()) . "'>"
                    . htmlspecialchars($spectacle->getTitre()) . "</a></h3>";
                $html .= "<p>" . htmlspecialchars($spectacle->getDescription()) . "</p>";
                $html .= "<p><strong>Genre :</strong> " . htmlspecialchars($spectacle->getGenre()) . "</p>";
                $html .= "<p><strong>Horaire :</strong> " . htmlspecialchars($spectacle->getHorairePrevuSpectacle()) . "</p>";
                $html .= "</li>";
            }

            $html .= "</ul>";
        } else {
            $html .= "<p>Aucun spectacle prévu pour cette soirée.</p>";
        }

        $html .= "</main>";

        // Footer
        $html .= $this->renderFooter();

        return $html;
    }
}
