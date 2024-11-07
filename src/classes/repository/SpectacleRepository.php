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
        $query = "SELECT titre,date,horairePrevisionnel,images FROM Spectacles JOIN SoireeToSpectacle ON Spectacles.idSpectacle=SoireeToSpectacle.idSpectacle JOIN Soirees ON SoireeToSpectale.idSoiree=Soirees.idSoiree JOIN Image ON Spectacles.idImage=Image.idImages WHERE idSpectacle = :idSpectacle";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSpectacle", $idSpectacle);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenirListeSpectacles() {
        $query = "
        SELECT Spectacles.idSpectacle, Spectacles.titre, Spectacles.horairePrevisionnel, Image.images
        FROM Spectacles
        JOIN Image ON Spectacles.idImage = Image.idImage
    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}