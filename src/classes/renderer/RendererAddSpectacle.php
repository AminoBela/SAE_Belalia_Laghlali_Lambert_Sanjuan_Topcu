<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererAddSpectacle
 *
 * Classe pour rendre le formulaire de création d'un spectacle.
 *
 * @package iutnc\nrv\renderer
 */
class RendererAddSpectacle extends Renderer
{
    /**
     * Rendu du formulaire de création d'un spectacle.
     *
     * @param array $data Le contexte contenant les données nécessaires pour le rendu.
     * @return string Le formulaire de création du spectacle rendu sous forme de chaîne de caractères.
     */
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');

        $header = $this->renderHeader('Créer un Spectacle - NRV Festival', 'styles/form.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="form-container">
            <h2>Créer un Spectacle</h2>
            <form action="?action=creerSpectacle" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="urlVideo">Vidéo :</label>
                    <input type="file" id="urlVideo" name="urlVideo" accept="video/*">
                </div>
                <div class="form-group">
                    <label for="urlAudio">Audio :</label>
                    <input type="file" id="urlAudio" name="urlAudio" accept="audio/*">
                </div>
                <div class="form-group">
                    <label for="horairePrevuSpectacle">Horaire prévu :</label>
                    <input type="time" id="horairePrevuSpectacle" name="horairePrevuSpectacle" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre :</label>
                    <input type="text" id="genre" name="genre" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="dureeSpectacle">Durée (minutes) :</label>
                    <input type="number" id="dureeSpectacle" name="dureeSpectacle" min="1" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-submit">Créer</button>
                </div>
            </form>
HTML;

        if (!empty($error)) {
            $body .= <<<HTML
            <div class="form-error">
                {$error}
            </div>
HTML;
        }

        $body .= <<<HTML
        </div>
HTML;

        return $header . $body . $footer;
    }
}
