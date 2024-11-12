<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\action\AddSpectacleAction;

class RendererAddSpectacle extends Renderer
{
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
                <input type="file" id="urlVideo" name="urlVideo" accept="video/*" required>
            </div>
            <div class="form-group">
                <label for="urlAudio">Audio :</label>
                <input type="file" id="urlAudio" name="urlAudio" accept="audio/*" required>
            </div>
            <div class="form-group">
                <label for="horairePrevuSpectacle">Horaire Prévu :</label>
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
        <div class="form-error">
            {$error}
        </div>
    </div>
    HTML;

        return $header . $body . $footer;
    }
}
