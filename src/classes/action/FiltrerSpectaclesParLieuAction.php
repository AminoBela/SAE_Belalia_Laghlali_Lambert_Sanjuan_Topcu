<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class FiltrerSpectaclesParLieuAction extends Action {

    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        $lieu = filter_var($_POST['lieu'] ?? '', FILTER_SANITIZE_STRING);

        if ($lieu) {
            $spectacles = $this->spectacleRepository->filtrerSpectaclesParLieu($lieu);

            if ($spectacles) {
                $res = "<h2>Spectacles pour le lieu : {$lieu}</h2>";
                foreach ($spectacles as $spectacle) {
                    $res .= "<div><h3>{$spectacle['titre']}</h3>";
                    $res .= "<p>Date : {$spectacle['date']}</p>";
                    $res .= "<img src='{$spectacle['images']}' alt='Image du spectacle'></div>";
                }
                return $res;
            }
            return "<p>Aucun spectacle trouvé pour ce lieu.</p>";
        }

        return <<<FORM
            <form method="post" action="?action=filtrer-spectacles-lieu">
                <label for="lieu">Lieu :</label>
                <input type="text" id="lieu" name="lieu" required>
                <input type="submit" value="Filtrer">
            </form>
        FORM;
    }
}
