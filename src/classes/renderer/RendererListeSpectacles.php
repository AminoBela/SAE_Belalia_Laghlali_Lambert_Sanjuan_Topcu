<?php

namespace iutnc\nrv\renderer;

class RendererListeSpectacles extends Renderer {

    public function renderListeSpectacles(array $spectacles): string {

        $header = $this->renderHeader('Liste des spectacles - NRV Festival');
        $footer = $this->renderFooter();

        // Formulaire de tri
        $html = "
            <form method='get' action='index.php'>
                <input type='hidden' name='action' value='afficherListeSpectacles'>
                <label for='sort'>Trier par :</label>
                <select name='sort' id='sort'>
                    <option value='date' " . ($this->isSelected('date') ? 'selected' : '') . ">Date</option>
                    <option value='genre' " . ($this->isSelected('genre') ? 'selected' : '') . ">Style de Musique</option>
                    <option value='lieu' " . ($this->isSelected('lieu') ? 'selected' : '') . ">Lieu</option>
                </select>
                <button type='submit'>Appliquer le tri</button>
            </form>
        ";

        $html .= "<div class='spectacle-list'>";

        // Boucle d'affichage des spectacles
        foreach ($spectacles as $spectacle) {
            $html .= "<div class='spectacle-item'>";
            $html .= "<h2>" . htmlspecialchars($spectacle['titre']) . "</h2>";
            $html .= "<p>Date : " . htmlspecialchars($spectacle['dateSoiree']) . "</p>";
            $html .= "<p>Horaire : " . htmlspecialchars($spectacle['horrairePrevuSpectacle']) . "</p>";
            $html .= "<p>Style de musique : " . htmlspecialchars($spectacle['genre']) . "</p>";
            $html .= "<p>Lieu : " . htmlspecialchars($spectacle['nomLieu']) . "</p>";
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

    // Fonction pour vérifier si un critère est sélectionné pour garder le tri dans le formulaire
    private function isSelected(string $sortCriteria): bool {
        return isset($_GET['sort']) && $_GET['sort'] === $sortCriteria;
    }

    public function render(array $context = []): string {
        return $this->renderListeSpectacles($context);
    }
}
