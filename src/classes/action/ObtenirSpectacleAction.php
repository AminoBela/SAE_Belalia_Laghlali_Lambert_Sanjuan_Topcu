<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;

class ObtenirSpectacleAction
{

    private SpectacleRepository $spectacleRepository;
    private string $http_method;

    public function __construct()
    {
        $this->spectacleRepository = new SpectacleRepository();
        $this->http_method = $_SERVER['REQUEST_METHOD'];
    }

    public function execute(): string
    {
        $res = "";

        if ($this->http_method == "GET") {
            $res = <<<FORM
                <form method="post" action="?action=obtenir-spectacle">
                    <input type="number" name="idSpectacle" placeholder="ID Spectacle" required>
                    <input type="submit" name="obtenir" value="Obtenir Spectacle">
                </form>
            FORM;
        } else {
            $idSpectacle = filter_var($_POST['idSpectacle'], FILTER_SANITIZE_NUMBER_INT);
            $spectacle = $this->spectacleRepository->obtenirSpectacleParId($idSpectacle);

            if ($spectacle) {
                $res = "<h2>Spectacle : {$spectacle['titre']}</h2>";
                $res .= "<p>Date : {$spectacle['date']}</p>";
                $res .= "<p>Horaire prévisionnel : {$spectacle['horairePrevisionnel']}</p>";
                $res .= "<p>Images : {$spectacle['images']}</p>";
            } else {
                $res = "Spectacle introuvable.";
            }
        }

        return $res;
    }
}
