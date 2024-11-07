<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class ObtenirSpectacleAction extends Action {

    private SpectacleRepository $spectacleRepository;
    private string $http_method;

    public function __construct() {
        $this->spectacleRepository = new SpectacleRepository();
        $this->http_method = $_SERVER['REQUEST_METHOD'];
    }

    public function execute(): string {
        if ($this->http_method == "GET") {
            $idSpectacle = filter_var($_GET['idSpectacle'] ?? '', FILTER_SANITIZE_NUMBER_INT);

            if ($idSpectacle) {
                $spectacle = $this->spectacleRepository->obtenirSpectacleParId($idSpectacle);

                if ($spectacle) {
                    return $this->renderSpectacleDetails($spectacle);
                } else {
                    return "<p>Spectacle introuvable.</p>";
                }
            } else {
                return <<<FORM
                <form method="post" action="?action=obtenir-spectacle">
                    <input type="number" name="idSpectacle" placeholder="ID Spectacle" required>
                    <input type="submit" name="obtenir" value="Obtenir Spectacle">
                </form>
            FORM;
            }
        } else {
            $idSpectacle = filter_var($_POST['idSpectacle'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            if ($idSpectacle) {
                $spectacle = $this->spectacleRepository->obtenirSpectacleParId($idSpectacle);

                if ($spectacle) {
                    return $this->renderSpectacleDetails($spectacle);
                } else {
                    return "<p>Spectacle introuvable.</p>";
                }
            }
        }

        return "<p>Aucun ID de spectacle fourni.</p>";
    }


    private function renderSpectacleDetails(array $spectacle): string {
        $res = "<h2>Spectacle : {$spectacle['titre']}</h2>";
        $res .= "<p>Artistes : {$spectacle['artistes']}</p>";
        $res .= "<p>Description : {$spectacle['description']}</p>";
        $res .= "<p>Style : {$spectacle['styleMusique']}</p>";
        $res .= "<p>Durée : {$spectacle['horairePrevisionnel']}</p>";
        $res .= "<img src='{$spectacle['images']}' alt='Image du spectacle'>";

        if ($spectacle['urlVideo']) {
            $res .= "<p>Vidéo : <a href='{$spectacle['urlVideo']}'>Voir l'extrait</a></p>";
        }

        return $res;
    }
}
