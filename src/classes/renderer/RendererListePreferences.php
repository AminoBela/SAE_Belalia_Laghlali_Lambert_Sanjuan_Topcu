<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\repository\PreferencesRepository;

class RendererListePreferences extends Renderer
{
    public function render(array $contexte = []): string
    {
        $spectacles = $contexte['spectacles'];

        $html = $this->renderHeader('Liste des spectacles préférés - NRV Festival', 'styles/spectacles.css');

        if (empty($spectacles)) {
            // ajouter plein de messages
            // ajoute l'icon de spectacle
            $html .= "<div class='no-preferences'>";
            $html .= "<img src='uploads/images/spectacle-icon.png' alt='Image du spectacle' class='image-spectacle-liste' width='100px' height='100px'>";
            $html .= "<h3>Vous n'avez pas de spectacles préférés.</h3>";
            $html .= "<h5>Retourner à la <a href='?action=afficherListeSpectacles'>liste des spectacles</a></h5>";
            $html .= "</div>";
            return $html;
        }

        $html .= "<div class='preferences-container'>";
        $html .= "<h1 class='titre-spectacle'>Liste des spectacles préférés</h1>";
        $html .= "<img src='uploads/images/spectacle-icon.png' alt='Image du spectacle' class='image-spectacle-liste' width='100px' height='100px'>";
        $html .= "</div>";

        $html .= "<div class='options-preferences'>";
        $html .= "<a href='?action=afficherListeSpectacles' class='home-button'>Voir les spectacles</a>";
        $html .= "</div>";

        $html .= "<div class='spectacle-list'>";

        $spectaclePref = PreferencesRepository::getInstance();

        foreach ($spectacles as $spectacle) {
            // vérifie si le spectacle est ajouté aux préférences
            if (isset($_GET['ajouterPref']) && $_GET['ajouterPref'] == $spectacle['idSpectacle']) {
                // mettre estAjoute pref a false s'il n'est pas dans le cookie ou s'il y est le mettre par rapport à sa valeur actuelle
                $spectaclePref->togglePref($spectacle['idSpectacle']);
            }

            if ($spectaclePref->estAjouterPref($spectacle['idSpectacle'])) {
                $html .= (new RendererSpectacle($spectacle))->render(["chemin" => "afficherPreferences"]);
            }
        }

        $html .= "</div>";

        return $html;
    }
}