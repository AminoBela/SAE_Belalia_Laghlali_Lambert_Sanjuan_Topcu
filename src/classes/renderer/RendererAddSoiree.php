<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\action\AddSoireeAction;

class RendererAddSoiree extends Renderer
{
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $header = $this->renderHeader('Créer une Soiree - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
    <h2>Créer une Soiree</h2>
    <form action="?action=creerSoiree" method="post" enctype="multipart/form-data">
        <div>
            <label for="nomSoiree">Nom de la soirée :</label>
            <input type="text" id="nomSoiree" name="nomSoiree" maxlength="255" required>
        </div>
        <div>
            <label for="thematique">thematique de la soirée :</label>
            <textarea id="thematique" name="thematique" required></textarea>
        </div>
        <div>
            <label for="dateSoiree">Date de la soirée :</label>
            <input type="text" id="dateSoiree" name="dateSoiree" maxlength="255" required>
        </div>
        <div>
            <label for="horraireDebut">horraire du debut de la soirée :</label>
            <input type="text" id="horraireDebut" name="horraireDebut" maxlength="255" required>
        </div>
        <div>
            <label for="idLieu">id du lieu :</label>
            <input type="number" id="idLieu" name="idLieu" min="1" required>
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