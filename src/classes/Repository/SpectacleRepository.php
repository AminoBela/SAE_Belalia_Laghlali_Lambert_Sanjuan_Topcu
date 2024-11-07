<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class SpectacleRepository {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::seConnecterBD();
    }

    public function ajouterSpectacle($titre, $artistes, $description, $idImage, $urlVideo, $horairePrevisionnel, $styleMusique) {
        $query = "INSERT INTO Spectacles (titre, artistes, description, idImage, urlVideo, horairePrevisionnel, styleMusique) VALUES (:titre, :artistes, :description, :idImage, :urlVideo, :horairePrevisionnel, :styleMusique)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":artistes", $artistes);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":idImage", $idImage);
        $stmt->bindParam(":urlVideo", $urlVideo);
        $stmt->bindParam(":horairePrevisionnel", $horairePrevisionnel);
        $stmt->bindParam(":styleMusique", $styleMusique);
        return $stmt->execute();
    }

    public function obtenirSpectacleParId($idSpectacle) {
        $query = "SELECT * FROM Spectacles WHERE idSpectacle = :idSpectacle";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSpectacle", $idSpectacle);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}