<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\action\AddSpectacleAction;

class RendererAddSpectacle extends Renderer
{
    public function render(array $data = []): string
    {
        $error = $data['error'] ?? '';
        $header = $this->renderHeader('Créer un Spectacle - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <h2>Créer un Spectacle</h2>
        <form action="?action=creerSpectacle" method="post">
            <div>
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div>
                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div>
                <label for="urlVideo">URL Vidéo :</label>
                <input type="url" id="urlVideo" name="urlVideo" required>
            </div>
            <div>
                <label for="urlAudio">URL Audio :</label>
                <input type="url" id="urlAudio" name="urlAudio" required>
            </div>
            <div>
                <label for="horairePrevuSpectacle">Horaire Prévu :</label>
                <input type="datetime-local" id="horairePrevuSpectacle" name="horairePrevuSpectacle" required>
            </div>
            <div>
                <label for="genre">Genre :</label>
                <input type="text" id="genre" name="genre" required>
            </div>
            <div>
                <label for="dureeSpectacle">Durée (minutes) :</label>
                <input type="number" id="dureeSpectacle" name="dureeSpectacle" required>
            </div>
            <button type="submit">Créer</button>
        </form>
        <div style="color: red;">
            $error
        </div>
        HTML;

        return $header . $body . $footer;
    }
}