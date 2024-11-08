<?php

namespace iutnc\nrv\renderer;

class RendererRegister extends Renderer
{
    public function render(array $data = []): string
    {
        $error = $data['error'] ?? '';
        $header = $this->renderHeader('Inscription - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <h2>Inscription pour le Staff NRV</h2>
        <form action="?action=register" method="post">
            <div>
                <label for="nomUtilisateur">Nom d'utilisateur :</label>
                <input type="text" id="nomUtilisateur" name="nomUtilisateur" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="passwordConfirm">Confirmer le mot de passe :</label>
                <input type="password" id="passwordConfirm" name="passwordConfirm" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        <div style="color: red;">
            $error
        </div>
        HTML;

        return $header . $body . $footer;
    }
}