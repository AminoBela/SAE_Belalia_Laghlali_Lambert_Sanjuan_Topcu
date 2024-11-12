<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\models\Lieu;
use PDO;

class LieuRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function getAllLieux(): array {
        $query = "SELECT idLieu, nomLieu FROM Lieu";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLieuById(int $idLieu): ?Lieu {
        $query = "SELECT * FROM Lieu WHERE idLieu = :idLieu";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idLieu', $idLieu, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Lieu(
                $data['idLieu'],
                $data['nomLieu'],
                $data['adresse'],
                $data['nombrePlacesAssises'],
                $data['nombrePlacesDebout']
            );
        }
        return null;
    }
}