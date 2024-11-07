<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class SoireeToSpectacle {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::obtenirBD();
    }

    public function lierSoireeSpectacle($idSoiree, $idSpectacle) {
        $query = "INSERT INTO SoireeToSpectacle (idSoiree, idSpectacle) VALUES (:idSoiree, :idSpectacle)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSoiree", $idSoiree);
        $stmt->bindParam(":idSpectacle", $idSpectacle);
        return $stmt->execute();
    }

    public function obtenirSpectaclesPourSoiree($idSoiree) {
        $query = "SELECT * FROM SoireeToSpectacle WHERE idSoiree = :idSoiree";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idSoiree", $idSoiree);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}