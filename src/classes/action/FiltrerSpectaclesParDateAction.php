<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class FiltrerSpectaclesParDateAction extends Action {

    private SpectacleRepository $spectacleRepository;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string {
        $date = filter_var($_POST['date'] ?? '', FILTER_SANITIZE_STRING);

        if ($date) {
            $spectacles = $this->spectacleRepository->filtrerSpectaclesParDate($date);

            if ($spectacles) {
                $res = "<h2>Spectacles pour la date : {$date}</h2>";
                foreach ($spectacles as $spectacle) {
                    $res .= "<div><h3>{$spectacle['titre']}</h3>";
                    $res .= "<p>Horaire : {$spectacle['horairePrevisionnel']}</p>";
                    $res .= "<img src='{$spectacle['images']}' alt='Image du spectacle'></div>";
                }
                return $res;
            }
            return "<p>Aucun spectacle trouvé pour cette date.</p>";
        }

        return <<<FORM
            <form method="post" action="?action=filtrer-spectacles-date">
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" required>
                <input type="submit" value="Filtrer">
            </form>
        FORM;
    }
}
