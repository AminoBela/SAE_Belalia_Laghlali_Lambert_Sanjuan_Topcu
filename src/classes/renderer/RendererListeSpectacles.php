<?php

namespace iutnc\nrv\renderer;

class RendererListeSpectacles extends Renderer {

    public function renderListeSpectacles(array $spectacles, array $jours, array $lieux, array $styles, string $selectedCriteria = '', string $selectedOption = ''): string {

        $header = $this->renderHeader('Liste des spectacles - NRV Festival');
        $footer = $this->renderFooter();

        // Formulaire de tri
        $html = "
            <form method='get' action='index.php'>
                <input type='hidden' name='action' value='afficherListeSpectacles'>
                <label for='filter-criteria'>Filtrer par :</label>
                <select name='filter-criteria' id='filter-criteria' onchange='this.form.submit()'>
                    <option value=''>Sélectionner un critère</option>
                    <option value='jour'" . ($selectedCriteria == 'jour' ? ' selected' : '') . ">Journée</option>
                    <option value='lieu'" . ($selectedCriteria == 'lieu' ? ' selected' : '') . ">Lieu</option>
                    <option value='style'" . ($selectedCriteria == 'style' ? ' selected' : '') . ">Style de musique</option>
                </select>";

        if ($selectedCriteria) {
            $html .= "<select name='filter-options' id='filter-options'>";
            $options = [];
            if ($selectedCriteria == 'jour') {
                $options = $jours;
            } elseif ($selectedCriteria == 'lieu') {
                $options = $lieux;
            } elseif ($selectedCriteria == 'style') {
                $options = $styles;
            }
            foreach ($options as $option) {
                $html .= "<option value='" . htmlspecialchars($option) . "'" . ($selectedOption == $option ? ' selected' : '') . ">" . htmlspecialchars($option) . "</option>";
            }
            $html .= "</select>";
        }

        $html .= "<button type='submit'>Appliquer le filtre</button>";
        $html .= "</form>";

        $html .= "<div class='spectacle-list'>";

        // Boucle d'affichage des spectacles
        foreach ($spectacles as $spectacle) {
            $html .= "<div class='spectacle-item'>";
            $html .= "<h2>" . htmlspecialchars($spectacle['titre']) . "</h2>";
            $html .= "<p>Date : " . htmlspecialchars($spectacle['dateSoiree']) . "</p>";
            $html .= "<p>Horaire : " . htmlspecialchars($spectacle['horrairePrevuSpectacle']) . "</p>";
            $html .= "<p>Style de musique : " . htmlspecialchars($spectacle['genre'] ?? 'N/A') . "</p>";
            $html .= "<p>Lieu : " . htmlspecialchars($spectacle['nomLieu'] ?? 'N/A') . "</p>";
            $html .= "<p>Description : " . htmlspecialchars($spectacle['description']) . "</p>";
            if (!empty($spectacle['urlImage'])) {
                $html .= "<img src='" . htmlspecialchars($spectacle['urlImage']) . "' alt='Image du spectacle'>";
            }
            $html .= "<a href='?action=spectacleDetails&idSpectacle=" . htmlspecialchars($spectacle['idSpectacle']) . "'>Voir plus</a>";
            $html .= "</div>";
        }

        $html .= "</div>";
        return $header . $html . $footer;
    }

    public function render(array $context = []): string {
        return $this->renderListeSpectacles(
            $context['spectacles'] ?? [],
            $context['jours'] ?? [],
            $context['lieux'] ?? [],
            $context['styles'] ?? [],
            $context['selectedCriteria'] ?? '',
            $context['selectedOption'] ?? ''
        );
    }
}