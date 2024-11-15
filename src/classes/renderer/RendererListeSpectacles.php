<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererListeSpectacles
 *
 * Classe pour rendre la liste des spectacles.
 *
 * @package iutnc\nrv\renderer
 */
class RendererListeSpectacles extends Renderer
{
    /**
     * Rendu de la liste des spectacles.
     *
     * @param array $spectacles La liste des spectacles à rendre.
     * @param array $jours La liste des jours disponibles pour le filtrage.
     * @param array $lieux La liste des lieux disponibles pour le filtrage.
     * @param array $styles La liste des styles disponibles pour le filtrage.
     * @param string $critereSelec Le critère de filtrage sélectionné.
     * @param string $selectedOption L'option sélectionnée pour le critère de filtrage.
     * @return string La liste des spectacles rendue sous forme de chaîne de caractères.
     */
    public function renderListeSpectacles(array $spectacles, array $jours, array $lieux, array $styles, string $critereSelec = '', string $selectedOption = ''): string {
        $header = $this->renderHeader('Liste des spectacles - NRV Festival', 'styles/spectacles.css');
        $footer = $this->renderFooter();

        $html = "
            <form class='filtre-options' method='get' action='index.php'>
                <input type='hidden' name='action' value='afficherListeSpectacles'>
                <label for='filter-criteria'>Filtrer par :</label>
                <select name='filter-criteria' id='filter-criteria' onchange='this.form.submit()'>
                    <option value=''>Sélectionner un critère</option>
                    <option value='jour'" . ($critereSelec == 'jour' ? ' selected' : '') . ">Journée</option>
                    <option value='lieu'" . ($critereSelec == 'lieu' ? ' selected' : '') . ">Lieu</option>
                    <option value='style'" . ($critereSelec == 'style' ? ' selected' : '') . ">Style de musique</option>
                </select>";

        if ($critereSelec) {
            $html .= "<select name='filter-options' id='filter-options'>";
            $options = [];
            if ($critereSelec == 'jour') {
                $options = $jours;
            } elseif ($critereSelec == 'lieu') {
                $options = $lieux;
            } elseif ($critereSelec == 'style') {
                $options = $styles;
            }
            foreach ($options as $option) {
                $html .= "<option value='" . htmlspecialchars($option, ENT_QUOTES, 'UTF-8') . "'" . ($selectedOption == $option ? ' selected' : '') . ">" . htmlspecialchars($option, ENT_QUOTES, 'UTF-8') . "</option>";
            }
            $html .= "</select>";
        }

        $html .= "<button type='submit'>Appliquer le filtre</button>";
        $html .= "</form>";

        $html .= "<div class='spectacle-list'>";

        foreach ($spectacles as $spectacle) {
            $titre = htmlspecialchars($spectacle['titre'], ENT_QUOTES, 'UTF-8');
            $date = htmlspecialchars($spectacle['dateSoiree'], ENT_QUOTES, 'UTF-8');
            $horaire = htmlspecialchars($spectacle['horrairePrevuSpectacle'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $style = htmlspecialchars($spectacle['genre'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $lieu = htmlspecialchars($spectacle['nomLieu'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($spectacle['description'], ENT_QUOTES, 'UTF-8');
            $urlImage = htmlspecialchars($spectacle['urlImage'] ?? '', ENT_QUOTES, 'UTF-8');
            $idSpectacle = htmlspecialchars($spectacle['idSpectacle'], ENT_QUOTES, 'UTF-8');

            $html .= "<div class='spectacle-item'>";
            $html .= "<div class='like'>";
            $html .= "<h2>{$titre}</h2>";
            $html .= LikeButton::renderLikeButton($idSpectacle, 25, "afficherListeSpectacles");
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
        }

        if (empty($spectacles)) {
            $html .= "<p class='no-spectacles'>Aucun spectacle disponible.</p>";
        }

        $html .= "</div>";
        return $header . $html . $footer;
    }

    /**
     * Rendu du contexte donné.
     *
     * @param array $contexte Le contexte pour le rendu.
     * @return string Le contenu rendu sous forme de chaîne de caractères.
     */
    public function render(array $contexte = []): string
    {
        return $this->renderListeSpectacles(
            $contexte['spectacles'] ?? [],
            $contexte['jours'] ?? [],
            $contexte['lieux'] ?? [],
            $contexte['styles'] ?? [],
            $contexte['selectedCriteria'] ?? '',
            $contexte['selectedOption'] ?? ''
        );
    }
}
