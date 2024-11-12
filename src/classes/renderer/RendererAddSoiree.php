<?php

namespace iutnc\nrv\renderer;

class RendererAddSoiree extends Renderer
{
    public function render(array $data = []): string
    {
        // Récupération des données nécessaires
        $error = htmlspecialchars($data['error'] ?? '', ENT_QUOTES, 'UTF-8');
        $lieux = $data['lieux'] ?? [];

        // Header et Footer
        $header = $this->renderHeader('Créer une Soirée - NRV Festival', 'styles/form.css');
        $footer = $this->renderFooter();

        // Début du contenu principal
        $body = <<<HTML
        <div class="form-container">
            <h2>Créer une Soirée</h2>
            <form action="?action=creerSoiree" method="post" enctype="multipart/form-data">
                <!-- Nom de la soirée -->
                <div class="form-group">
                    <label for="nomSoiree">Nom de la soirée :</label>
                    <input type="text" id="nomSoiree" name="nomSoiree" maxlength="255" required>
                </div>
                <!-- Thématique -->
                <div class="form-group">
                    <label for="thematique">Thématique de la soirée :</label>
                    <textarea id="thematique" name="thematique" required></textarea>
                </div>
                <!-- Date -->
                <div class="form-group">
                    <label for="dateSoiree">Date de la soirée :</label>
                    <input type="date" id="dateSoiree" name="dateSoiree" required>
                </div>
                <!-- Horaire -->
                <div class="form-group">
                    <label for="horraireDebut">Horaire du début de la soirée :</label>
                    <input type="time" id="horraireDebut" name="horraireDebut" required>
                </div>
                <!-- Lieu -->
                <div class="form-group">
                    <label for="idLieu">Lieu :</label>
                    <select id="idLieu" name="idLieu" required>
                        <option value="">Sélectionnez un lieu</option>
HTML;

        // Génération dynamique des options des lieux
        foreach ($lieux as $lieu) {
            $idLieu = htmlspecialchars($lieu['idLieu'], ENT_QUOTES, 'UTF-8');
            $nomLieu = htmlspecialchars($lieu['nomLieu'], ENT_QUOTES, 'UTF-8');
            $body .= "<option value='{$idLieu}'>{$nomLieu}</option>";
        }

        // Fin du formulaire
        $body .= <<<HTML
                    </select>
                </div>
                <!-- Bouton de soumission -->
                <button type="submit" class="form-submit">Créer</button>
            </form>
HTML;

        // Affichage du message d'erreur, s'il existe
        if (!empty($error)) {
            $body .= <<<HTML
            <div class="error-message">
                {$error}
            </div>
HTML;
        }

        // Fermeture du conteneur
        $body .= <<<HTML
        </div>
HTML;

        // Retourne l'ensemble de la page
        return $header . $body . $footer;
    }
}
