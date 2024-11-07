<?php

namespace iutnc\nrv\action;

use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\bd\ConnectionBD;

class AddSpectacleAction
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
                <form method="post" action="?action=add-spectacle">
                    <input type="text" name="titre" placeholder="Titre" required>
                    <input type="text" name="artistes" placeholder="Artistes" required>
                    <input type="text" name="description" placeholder="Description" required>
                    <input type="number" name="idImage" placeholder="ID Image" required>
                    <input type="text" name="urlVideo" placeholder="URL Vidéo" required>
                    <input type="datetime-local" name="horairePrevisionnel" placeholder="Horaire Prévisionnel" required>
                    <input type="text" name="styleMusique" placeholder="Style Musique" required>
                    <input type="submit" name="ajouter" value="Ajouter Spectacle">
                </form>
            FORM;
        } else {
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_STRING);
            $artistes = filter_var($_POST['artistes'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $idImage = filter_var($_POST['idImage'], FILTER_SANITIZE_NUMBER_INT);
            $urlVideo = filter_var($_POST['urlVideo'], FILTER_SANITIZE_STRING);
            $horairePrevisionnel = filter_var($_POST['horairePrevisionnel'], FILTER_SANITIZE_STRING);
            $styleMusique = filter_var($_POST['styleMusique'], FILTER_SANITIZE_STRING);

            $resultat = $this->spectacleRepository->ajouterSpectacle(
                $titre, $artistes, $description, $idImage, $urlVideo, $horairePrevisionnel, $styleMusique
            );

            if ($resultat) {
                $res = "Spectacle ajouté avec succès.";
            } else {
                $res = "Erreur lors de l'ajout du spectacle.";
            }

            $res .= '<a href="?action=add-spectacle">Ajouter un autre spectacle</a>';
        }

        return $res;
    }
}
