<?php

namespace iutnc\nrv\renderer;

class RendererLogin extends Renderer
{
    public function render(array $data = []): string
    {
        $error = $data['error'] ?? '';
        $header = $this->renderHeader('Connexion - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
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
        <div style="color: red;">
            $error
        </div>
        HTML;

        return $header . $body . $footer;
    }
}