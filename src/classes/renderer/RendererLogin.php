<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererLogin
 *
 * Classe pour rendre le formulaire de connexion.
 *
 * @package iutnc\nrv\renderer
 */
class RendererLogin extends Renderer
{
    /**
     * Rendu du formulaire de connexion.
     *
     * @param array $data Le contexte contenant les données nécessaires pour le rendu.
     * @return string Le formulaire de connexion rendu sous forme de chaîne de caractères.
     */
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $header = $this->renderHeader('Connexion - NRV Festival', 'styles/login.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="login-container">
            <h2>Connexion pour le Staff NRV</h2>
            <form action="?action=login" method="post">
                <div>
                    <label for="email">Email :</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Se connecter</button>
                <div>
                    <a href="?action=register">Pas encore inscrit ? Inscrivez-vous</a>
                </div>
            </form>
            <div class="error-message">
                {$error}
            </div>
        </div>
HTML;

        return $header . $body . $footer;
    }
}
