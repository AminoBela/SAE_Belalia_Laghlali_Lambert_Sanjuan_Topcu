<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\repository\PreferencesRepository;

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
    public function renderListeSpectacles(array $spectacles, array $jours, array $lieux, array $styles, string $critereSelec = '', string $selectedOption = ''): string
    {
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

        $spectaclePref = PreferencesRepository::getInstance();

        foreach ($spectacles as $spectacle) {
            if (isset($_GET['ajouterPref']) && $_GET['ajouterPref'] == $spectacle['idSpectacle']) {
                // mettre estAjoute pref a false s'il n'est pas dans le cookie ou s'il y est le mettre par rapport à sa valeur actuelle
                $spectaclePref->togglePref($spectacle['idSpectacle']);
            }

            $html .= (new RendererSpectacle($spectacle))->render();
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
