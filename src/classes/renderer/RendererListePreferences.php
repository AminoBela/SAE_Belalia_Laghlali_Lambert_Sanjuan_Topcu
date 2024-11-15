<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\repository\PreferencesRepository;

/**
 * Rend la page de la liste des spectacles préférés.
 */
class RendererListePreferences extends Renderer
{
    /**
     * Rend la page de la liste des spectacles préférés.
     * @param array $contexte Données à afficher (ici, les spectacles préférés).
     * @return string Code HTML de la page des préférences.
     */
    public function render(array $contexte = []): string
    {
        // Récupérer les spectacles préférés
        $spectacles = $contexte['spectacles'];

        // Rendu du tab (en haut du navigateur de la page)
        $html = $this->renderHeader('Liste des spectacles préférés - NRV Festival', 'styles/spectacles.css');

        // Si l'utilisateur n'a pas de spectacles préférés
        if (empty($spectacles)) {
            // Afficher un message avec un lien pour retourner à la liste des spectacles
            $html .= "<div class='no-preferences'>";
            $html .= "<img src='uploads/images/spectacle-icon.png' alt='Image du spectacle' class='image-spectacle-liste' width='100px' height='100px'>";
            $html .= "<h3>Vous n'avez pas de spectacles préférés.</h3>";
            $html .= "<h5>Retourner à la <a href='?action=afficherListeSpectacles'>liste des spectacles</a></h5>";
            $html .= "</div>";
            return $html;
        }

        // Afficher le titre de la page
        $html .= "<div class='preferences-container'>";
        $html .= "<h1 class='titre-spectacle'>Liste des spectacles préférés</h1>";
        $html .= "<img src='uploads/images/spectacle-icon.png' alt='Image du spectacle' class='image-spectacle-liste' width='100px' height='100px'>";
        $html .= "</div>";

        // Afficher le bouton pour retourner à la liste des spectacles
        $html .= "<div class='options-preferences'>";
        $html .= "<a href='?action=afficherListeSpectacles' class='home-button'>Voir les spectacles</a>";
        $html .= "</div>";

        $html .= "<div class='spectacle-list'>";

        $spectaclePref = PreferencesRepository::getInstance();

        // Afficher les spectacles préférés
        foreach ($spectacles as $spectacle) {
            // vérifie si le spectacle est ajouté aux préférences
            if (isset($_GET['ajouterPref']) && $_GET['ajouterPref'] == $spectacle['idSpectacle']) {
                // mettre estAjoute pref a false s'il n'est pas dans le cookie ou s'il y est le mettre par rapport à sa valeur actuelle
                $spectaclePref->togglePref($spectacle['idSpectacle']);
            }

            // Si le spectacle est préféré, l'afficher (pour éviter d'afficher celui qu'on vient de désélectionner)
            if ($spectaclePref->estAjouterPref($spectacle['idSpectacle'])) {
                $html .= (new RendererSpectacle($spectacle))->render(["chemin" => "afficherPreferences"]);
            }
        }

        $html .= "</div>";

        return $html;
    }
}