<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererRegister
 *
 * Classe pour rendre le formulaire d'inscription.
 *
 * @package iutnc\nrv\renderer
 */
class RendererRegister extends Renderer
{
    /**
     * Rendu du formulaire d'inscription.
     *
     * @param array $data Le contexte contenant les données nécessaires pour le rendu.
     * @return string Le formulaire d'inscription rendu sous forme de chaîne de caractères.
     */
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $header = $this->renderHeader('Inscription - NRV Festival', 'styles/login.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="login-container">
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
            <div class="error-message">
                {$error}
            </div>
        </div>
        HTML;

        return $header . $body . $footer;
    }
}
