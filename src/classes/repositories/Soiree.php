<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class Soiree {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::seConnecterBD();
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
}