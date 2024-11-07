<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class FiltrerSpectaclesParStyleAction extends Action {

    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        $style = filter_var($_POST['styleMusique'] ?? '', FILTER_SANITIZE_STRING);

        if ($style) {
            $spectacles = $this->spectacleRepository->filtrerSpectaclesParStyle($style);

            if ($spectacles) {
                $res = "<h2>Spectacles pour le style : {$style}</h2>";
                foreach ($spectacles as $spectacle) {
                    $res .= "<div><h3>{$spectacle['titre']}</h3>";
                    $res .= "<p>Date : {$spectacle['date']}</p>";
                    $res .= "<img src='{$spectacle['images']}' alt='Image du spectacle'></div>";
                }
                return $res;
            }
            return "<p>Aucun spectacle trouvé pour ce style de musique.</p>";
        }

        return <<<FORM
            <form method="post" action="?action=filtrer-spectacles-style">
                <label for="styleMusique">Style de Musique :</label>
                <input type="text" id="styleMusique" name="styleMusique" required>
                <input type="submit" value="Filtrer">
            </form>
        FORM;
    }
}
