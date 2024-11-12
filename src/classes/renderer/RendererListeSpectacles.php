<?php
namespace iutnc\nrv\renderer;
header('Content-Type: text/html; charset=utf-8');

class RendererListeSpectacles extends Renderer
{

    public function renderListeSpectacles(
        array $spectacles,
        array $jours,
        array $lieux,
        array $styles,
        string $selectedCriteria = '',
        string $selectedOption = ''
    ): string {
        // Inclure le fichier CSS spécifique
        $header = $this->renderHeader('Liste des spectacles - NRV Festival', 'styles/spectacles.css');
        $footer = $this->renderFooter();

        // Formulaire de filtrage
        $html = "
            <form class='filtre-options' method='get' action='index.php'>
                <input type='hidden' name='action' value='afficherListeSpectacles'>
                <label for='filter-criteria'>Filtrer par :</label>
                <select name='filter-criteria' id='filter-criteria' onchange='this.form.submit()'>
                    <option value=''>Sélectionner un critère</option>
                    <option value='jour'" . ($selectedCriteria == 'jour' ? ' selected' : '') . ">Journée</option>
                    <option value='lieu'" . ($selectedCriteria == 'lieu' ? ' selected' : '') . ">Lieu</option>
                    <option value='style'" . ($selectedCriteria == 'style' ? ' selected' : '') . ">Style de musique</option>
                </select>";

        // Affichage des options de filtrage dynamiques
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

        // Liste des spectacles
        $html .= "<div class='spectacle-list'>";

        foreach ($spectacles as $spectacle) {
            $titre = htmlspecialchars($spectacle['titre']);
            $date = htmlspecialchars($spectacle['dateSoiree']);
            $horaire = htmlspecialchars($spectacle['horrairePrevuSpectacle'] ?? 'N/A');
            $style = htmlspecialchars($spectacle['genre'] ?? 'N/A');
            $lieu = htmlspecialchars($spectacle['nomLieu'] ?? 'N/A');
            $description = htmlspecialchars($spectacle['description']);
            $urlImage = htmlspecialchars($spectacle['urlImage'] ?? '');
            $idSpectacle = htmlspecialchars($spectacle['idSpectacle']);

            $html .= "<div class='spectacle-item'>";
            $html .= "<h2>{$titre}</h2>";
            $html .= "<p>Date : {$date}</p>";
            $html .= "<p>Horaire : {$horaire}</p>";
            $html .= "<p>Style de musique : {$style}</p>";
            $html .= "<p>Lieu : {$lieu}</p>";
            $html .= "<p>Description : {$description}</p>";

            if (!empty($urlImage)) {
                $html .= "<img src='{$urlImage}' alt='Image du spectacle'>";
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

    public function render(array $context = []): string
    {
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
