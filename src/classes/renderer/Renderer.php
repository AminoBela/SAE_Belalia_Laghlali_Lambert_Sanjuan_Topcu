<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\auth\Authentification;

abstract class Renderer
{
    protected function renderHeader(string $title, ?string $stylesheet = null): string
    {
        $navLinks = Authentification::isLogged() ?
            '<a href="?action=logout">Déconnexion</a>' :
            '<a href="?action=login">Connexion</a><a href="?action=register">Inscription</a>';

        $autreStyle = $stylesheet ?? "";

        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$title}</title>
            <link rel="stylesheet" href="styles.css">
            <link rel="stylesheet" href="{$autreStyle}">
            <header>
                <h1>NRV Festival</h1>
            </header>
        </head>
        <body>
            <nav>
                <a href="?action=default">Accueil</a>
                <a href="?action=afficherListeSpectacles">Liste des spectacles</a>
                <a href="?action=creerSpectacle">Créer un spectacle</a>
                {$navLinks}
            </nav>
        HTML;
    }

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

    abstract public function render(array $context = []): string;
}