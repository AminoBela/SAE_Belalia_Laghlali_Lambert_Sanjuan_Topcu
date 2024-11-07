<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class SoireeRepository {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::obtenirBD();
    }

    public function ajouterSoiree($nom, $thematique, $date, $horaireDebut, $idLieu) {
        $query = "INSERT INTO Soirees (nom, thematique, date, horaireDebut, idLieu) VALUES (:nom, :thematique, :date, :horaireDebut, :idLieu)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":thematique", $thematique);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":horaireDebut", $horaireDebut);
        $stmt->bindParam(":idLieu", $idLieu);
        return $stmt->execute();
    }

    public function obtenirSoireeParId($idSoiree) {
        $query = "SELECT * FROM Soirees WHERE idSoiree = :idSoiree";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSoiree", $idSoiree);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenirDetailsSoireeAvecSpectacles($idSoiree) {
        $query = "
            SELECT Soirees.nom, Soirees.thematique, Soirees.date, Soirees.horaireDebut,
                   Lieux.nom AS lieuNom, Lieux.adresse, Lieux.nombrePlacesAssises, Lieux.nombrePlacesDebout,
                   Spectacles.idSpectacle, Spectacles.titre, Spectacles.artistes, Spectacles.description, Spectacles.styleMusique, Spectacles.urlVideo
            FROM Soirees
            JOIN Lieux ON Soirees.idLieu = Lieux.idLieu
            LEFT JOIN SoireeToSpectacle ON Soirees.idSoiree = SoireeToSpectacle.idSoiree
            LEFT JOIN Spectacles ON SoireeToSpectacle.idSpectacle = Spectacles.idSpectacle
            WHERE Soirees.idSoiree = :idSoiree
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSoiree", $idSoiree);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenirToutesSoirees() {
        $query = "SELECT * FROM Soirees";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
