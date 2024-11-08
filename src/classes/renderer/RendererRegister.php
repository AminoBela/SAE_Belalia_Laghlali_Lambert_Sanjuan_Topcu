<?php

namespace iutnc\nrv\renderer;

class RendererRegister extends Renderer
{

    public function render(string $error = ''): string
    {
        $header = $this->renderHeader('Inscription - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <h2>Inscription pour le Staff NRV</h2>
        <form action="?action=register" method="post" >
            <div>
                <label for="nomUtilisateur">Nom d'utilisateur :</label>
                <input type="text" id="nomUtilisateur" name="nomUtilisateur" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="password2">Confirmer le mot de passe :</label>
                <input type="password" id="password2" name="password2" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        HTML;

        if ($error) {
            $body .= "<p style='color: red;'>{$error}</p>";
        }

        return $header . $body . $footer;
    }

}