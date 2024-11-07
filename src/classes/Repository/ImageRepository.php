<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class ImageRepository {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::seConnecterBD();
    }

    public function ajouterImage($images) {
        $query = "INSERT INTO Image (images) VALUES (:images)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":images", $images);
        return $stmt->execute();
    }

    public function obtenirImageParId($idImage) {
        $query = "SELECT * FROM Image WHERE idImage = :idImage";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":idImage", $idImage);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
