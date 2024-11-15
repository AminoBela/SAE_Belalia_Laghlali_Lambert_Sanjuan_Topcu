<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererAddSoiree
 *
 * Classe pour rendre le formulaire de création d'une soirée.
 *
 * @package iutnc\nrv\renderer
 */
class RendererAddSoiree extends Renderer
{
    /**
     * Rendu du formulaire de création d'une soirée.
     *
     * @param array $data Le contexte contenant les données nécessaires pour le rendu.
     * @return string Le formulaire de création de la soirée rendu sous forme de chaîne de caractères.
     */
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $lieux = $data['lieux'] ?? [];

        $header = $this->renderHeader('Créer une Soirée - NRV Festival', 'styles/form.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="form-container">
            <h2>Créer une Soirée</h2>
            <form action="?action=creerSoiree" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nomSoiree">Nom de la soirée :</label>
                    <input type="text" id="nomSoiree" name="nomSoiree" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="thematique">Thématique de la soirée :</label>
                    <textarea id="thematique" name="thematique" required></textarea>
                </div>
                <div class="form-group">
                    <label for="dateSoiree">Date de la soirée :</label>
                    <input type="date" id="dateSoiree" name="dateSoiree" required>
                </div>
                <div class="form-group">
                    <label for="horraireDebut">Horaire du début de la soirée :</label>
                    <input type="time" id="horraireDebut" name="horraireDebut" required>
                </div>
                <div class="form-group">
                <label for="tarif">Tarif (euro) :</label>
                <input type="number" id="tarif" name="tarif" min="0" required>
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
                    <button type="submit" class="form-submit">Créer</button>
                </div>
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
