<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class Spectacle {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::obtenirBD();
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
        $query = "SELECT titre,date,horairePrevisionnel,images FROM Spectacles JOIN SoireeToSpectacle ON Spectacles.idSpectacle=SoireeToSpectacle.idSpectacle JOIN Soirees ON SoireeToSpectale.idSoiree=Soirees.idSoiree JOIN Image ON Spectacles.idImage=Image.idImages";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrerParDate($date) {
        $query = "
        SELECT Spectacles.idSpectacle, Spectacles.titre, Spectacles.horairePrevisionnel, Image.images
        FROM Spectacles
        JOIN Image ON Spectacles.idImage = Image.idImage
        WHERE Spectacles.date = :date
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function filtrerParStyleMusique($styleMusique) {
        $query = "
        SELECT Spectacles.idSpectacle, Spectacles.titre, Spectacles.horairePrevisionnel, Image.images
        FROM Spectacles
        JOIN Image ON Spectacles.idImage = Image.idImage
        WHERE Spectacles.styleMusique = :styleMusique
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":styleMusique", $styleMusique);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function filtrerParLieu($lieu) {
        $query = "
        SELECT Spectacles.idSpectacle, Spectacles.titre, Spectacles.horairePrevisionnel, Image.images
        FROM Spectacles
        JOIN Image ON Spectacles.idImage = Image.idImage
        JOIN SoireeToSpectacle ON Spectacles.idSpectacle = SoireeToSpectacle.idSpectacle
        JOIN Soirees ON SoireeToSpectacle.idSoiree = Soirees.idSoiree
        JOIN Lieux ON Soirees.idLieu = Lieux.idLieu
        WHERE Lieux.nom = :lieu
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":lieu", $lieu);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}