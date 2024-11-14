<?php

namespace iutnc\nrv\renderer;

class RendererAddSpectacleToSoiree extends Renderer
{
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $spectacles = $data['idSpectacle'] ?? [];
        $lieux = $data['lieux'] ?? [];


        $header = $this->renderHeader('Ajouter un Spectacle à une Soirée - NRV Festival', 'styles/form.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="form-container">
            <h2>Ajouter un Spectacle à une Soirée</h2>
            <form action="?action=SpectacleToSoiree" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="dateSoiree">Date de la soirée :</label>
                    <input type="date" id="dateSoiree" name="dateSoiree" required>
                </div>
                
                
                
                <div class="form-group">
                    <label for="idLieu">Lieu :</label>
                    <select id="idLieu" name="idLieu" required>
                        <option value="">Sélectionnez un lieu</option>
HTML;

        foreach ($lieux as $lieu) {
            $idLieu = htmlspecialchars($lieu['idLieu'], ENT_QUOTES, 'UTF-8');
            $nomLieu = htmlspecialchars($lieu['nomLieu'], ENT_QUOTES, 'UTF-8');
            $body .= "<option value='{$idLieu}'>{$nomLieu}</option>";
        }

        $body .= <<<HTML
                    </select>
                </div>
                
                
                
                <div class="form-group">
                    <label for="idSpectacle">Spectacle :</label>
                    <select id="idSpectacle" name="idSpectacle" required>
                        <option value="">Sélectionnez un spectacle</option>
HTML;

        foreach ($spectacles as $spectacle) {
            $idSpectacle = htmlspecialchars((string)$spectacle['idSpectacle'], ENT_QUOTES, 'UTF-8');
            $nomSpectacle = htmlspecialchars($spectacle['titre'], ENT_QUOTES, 'UTF-8');
            $body .= "<option value='{$idSpectacle}'>{$nomSpectacle}</option>";
        }

        $body .= <<<HTML
                    </select>
                </div>
                <button type="submit" class="form-submit">Ajouter</button>
            </form>
HTML;

        if (!empty($error)) {
            $body .= <<<HTML
            <div class="error-message">
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