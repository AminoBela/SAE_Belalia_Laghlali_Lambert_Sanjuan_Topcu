<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererDetailsSpectacle;
use iutnc\nrv\repository\SpectacleRepository;

/**
 * Class SpectacleDetailsAction
 *
 * Action pour afficher les détails d'un spectacle dans le système.
 *
 * @package iutnc\nrv\action
 */
class SpectacleDetailsAction extends Action
{
    /**
     * Exécute l'action d'affichage des détails d'un spectacle.
     *
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string
    {
        // Crée une instance du dépôt des spectacles.
        $spectacleRep = new SpectacleRepository();

        // Récupère le spectacle en fonction de l'ID fourni dans les paramètres GET.
        $spectacle = $spectacleRep->obtenirSpectacleParId(htmlspecialchars($_GET['idSpectacle'], ENT_QUOTES, 'UTF-8'));

        // Vérifie si le spectacle existe.
        if ($spectacle != null) {
            // Utilise le renderer pour afficher les détails du spectacle.
            return (new RendererDetailsSpectacle($spectacle))->render();
        } else {
            // Retourne un message si le spectacle n'est pas trouvé.
            return "<p>Spectacle introuvable.</p>";
        }
    }
}
