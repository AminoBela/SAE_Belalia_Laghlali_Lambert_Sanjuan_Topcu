<?php

namespace iutnc\nrv\renderer;

/**
 * Class RendererAddSpectacleToSoiree
 *
 * Classe pour rendre le formulaire d'ajout d'un spectacle à une soirée.
 *
 * @package iutnc\nrv\renderer
 */
class RendererAddSpectacleToSoiree extends Renderer
{
    /**
     * Rendu du formulaire d'ajout d'un spectacle à une soirée.
     *
     * @param array $data Le contexte contenant les données nécessaires pour le rendu.
     * @return string Le formulaire d'ajout du spectacle à la soirée rendu sous forme de chaîne de caractères.
     */
    public function render(array $data = []): string
    {
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $spectacles = $data['idSpectacle'] ?? [];
        $soirees = $data['soirees'] ?? [];

        $header = $this->renderHeader('Ajouter un Spectacle à une Soirée - NRV Festival', 'styles/form.css');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <div class="form-container">
            <h2>Ajouter un Spectacle à une Soirée</h2>
            <form action="?action=ajouterSpectacleToSoiree" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="idLieu">Soirée :</label>
                    <select id="Soiree" name="Soiree" required>
                        <option value="">Sélectionnez une soirée</option>
HTML;

        foreach ($soirees as $soiree) {
            $idLieu = htmlspecialchars($soiree['idLieu'], ENT_QUOTES, 'UTF-8');
            $dateSoiree = (new \DateTime($soiree['dateSoiree']))->format('Y-m-d'); // Reformater en type date
            $dateSoiree = htmlspecialchars($dateSoiree, ENT_QUOTES); // Assurez-vous d'échapper la date reformattée
            $nomSoiree = htmlspecialchars($soiree['nomSoiree'], ENT_QUOTES, 'UTF-8');
            $body .= "<option value='{$idLieu},{$dateSoiree}'>{$nomSoiree}</option>";
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
            $idSpectacle = htmlspecialchars($spectacle['idSpectacle'], ENT_QUOTES, 'UTF-8');
            $nomSpectacle = htmlspecialchars($spectacle['titre'], ENT_QUOTES, 'UTF-8');
            $body .= "<option value='{$idSpectacle}'>{$nomSpectacle}</option>";
        }

        $body .= <<<HTML
                    </select>
                </div>
                <button type="submit" class="btn-creer-soiree">Ajouter</button>
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
