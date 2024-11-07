<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class Lieu {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::seConnecterBD();
    }

    public function ajouterLieu($nom, $adresse, $placesAssises, $placesDebout, $idImage) {
        $query = "INSERT INTO Lieux (nom, adresse, nombrePlacesAssises, nombrePlacesDebout, idImage) VALUES (:nom, :adresse, :placesAssises, :placesDebout, :idImage)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":placesAssises", $placesAssises);
        $stmt->bindParam(":placesDebout", $placesDebout);
        $stmt->bindParam(":idImage", $idImage);
        return $stmt->execute();
    }

    public function obtenirLieuParId($idLieu) {
        $query = "SELECT * FROM Lieux WHERE idLieu = :idLieu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idLieu", $idLieu);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
