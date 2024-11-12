<?php

namespace iutnc\nrv\renderer;

class RendererHome extends Renderer
{
    /**
     * Rend la page d'accueil.
     *
     * @param array|null $data Données à afficher (non utilisé ici, mais respecté pour la signature).
     * @return string Code HTML de la page d'accueil.
     */
    public function render(?array $data = null): string
    {
        $html = $this->renderHeader("Accueil", "styles/home.css"); // Inclure le CSS de la page d'accueil
        $html .= "
            <div class='home-container'>
                <h1>Bienvenue au NRV Festival</h1>
                <p>Découvrez les meilleurs spectacles et soirées musicales de Nancy Rock Vibration.</p>
                <a href='?action=afficherListeSpectacles' class='home-button'>Voir les spectacles</a>
            </div>
        ";
        $html .= $this->renderFooter();
        return $html;
    }
}
