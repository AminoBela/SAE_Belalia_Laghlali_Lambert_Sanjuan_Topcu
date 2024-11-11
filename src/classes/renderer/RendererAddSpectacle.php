<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\action\AddSpectacleAction;

class RendererAddSpectacle extends Renderer
{
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $header = $this->renderHeader('Créer un Spectacle - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
    <h2>Créer un Spectacle</h2>
    <form action="?action=creerSpectacle" method="post" enctype="multipart/form-data">
        <div>
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" maxlength="255" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="urlVideo">Vidéo :</label>
            <input type="file" id="urlVideo" name="urlVideo" accept="video/*" required>
        </div>
        <div>
            <label for="urlAudio">Audio :</label>
            <input type="file" id="urlAudio" name="urlAudio" accept="audio/*" required>
        </div>
        <div>
            <label for="horairePrevuSpectacle">Horaire Prévu :</label>
            <input type="datetime-local" id="horairePrevuSpectacle" name="horairePrevuSpectacle" required>
        </div>
        <div>
            <label for="genre">Genre :</label>
            <input type="text" id="genre" name="genre" maxlength="100" required>
        </div>
        <div>
            <label for="dureeSpectacle">Durée (minutes) :</label>
            <input type="number" id="dureeSpectacle" name="dureeSpectacle" min="1" required>
        </div>
        <button type="submit">Créer</button>
    </form>
    <div style="color: red;">
        <?php echo isset($error) ? htmlspecialchars($error) : ''; ?>
    </div>

    HTML;

        return $header . $body . $footer;
    }

}