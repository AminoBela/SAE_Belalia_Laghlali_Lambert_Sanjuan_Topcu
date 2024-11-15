<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\auth\Authentification;

/**
 * Class Renderer
 *
 * Classe abstraite pour les renderers du système NRV Festival.
 *
 * @package iutnc\nrv\renderer
 */
abstract class Renderer
{
    /**
     * Génère l'en-tête HTML pour la page.
     *
     * @param string $title Le titre de la page.
     * @param string|null $stylesheet Le chemin vers la feuille de style CSS supplémentaire.
     * @return string L'en-tête HTML généré.
     */
    protected function renderHeader(string $title, ?string $stylesheet = null): string
    {
        $navLinks = Authentification::isLogged() ?
            '<div class="dropdown">
                <button class="dropbtn">Administration</button>
                <div class="dropdown-content">
                    <a href="?action=creerSoiree">Créer une soirée</a>
                    <a href="?action=creerSpectacle">Créer un spectacle</a>
                    <a href="?action=ajouterSpectacleToSoiree">Lier un spectacle et une soirée</a>
                </div>
            </div>' .
            '<a href="?action=logout">Déconnexion</a>' :
            '<a href="?action=login">Connexion</a>' .
            '<a href="?action=register">Inscription</a>';

        $autreStyle = htmlspecialchars($stylesheet ?? '', ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$title}</title>
            <link rel="stylesheet" href="styles/global.css">
            <link rel="stylesheet" href="{$autreStyle}">
            <header>
                <h1>NRV Festival</h1>
            </header>
        </head>
        <body>
            <nav>
                <div class="nav-left">
                    <a href="?action=default">Accueil</a>
                    <a href="?action=afficherListeSpectacles">Liste des spectacles</a>
                    <a href="?action=afficherListeSoirees">Liste des soirées</a>
                </div>
                <div class="nav-right">
                    {$navLinks}
                </div>
            </nav>
        HTML;
    }

    /**
     * Génère le pied de page HTML pour la page.
     *
     * @return string Le pied de page HTML généré.
     */
    protected function renderFooter(): string
    {
        return <<<HTML
        </body>
            <footer>
                <p>&copy; 2024 NRV Festival</p>
                <p>Site réalisé par Amin, Noah, Valentino, Nicolas et Semih</p>
            </footer>
        </html>
        HTML;
    }

    /**
     * Méthode abstraite pour le rendu du contenu.
     *
     * @param array $contexte Le contexte pour le rendu.
     * @return string Le contenu rendu.
     */
    abstract public function render(array $contexte = []): string;
}
