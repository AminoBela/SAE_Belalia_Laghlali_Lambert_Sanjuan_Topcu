<?php

namespace iutnc\nrv\renderer;

class RendererAddSoiree extends Renderer
{
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $lieux = $data['lieux'] ?? [];
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
            <input type="date" id="dateSoiree" name="dateSoiree" required>
        </div>
        <div>
            <label for="horraireDebut">horraire du debut de la soirée :</label>
            <input type="time" id="horraireDebut" name="horraireDebut" required>
        </div>
        <div>
            <label for="idLieu">Lieu :</label>
            <select id="idLieu" name="idLieu" required>
                <option value="">Sélectionnez un lieu</option>
HTML;
        foreach ($lieux as $lieu) {
            $body .= "<option value='{$lieu['idLieu']}'>{$lieu['nomLieu']}</option>";
        }
        $body .= <<<HTML
            </select>
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