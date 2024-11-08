<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class ImageRepository
{
    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function getImageDepuisSpec(int $idSpectacle): array
    {
        $query = "
            SELECT i.urlImage
            FROM Image i
            LEFT JOIN ImageToSpectacle its ON i.idImage = its.idImage
            WHERE its.idSpectacle = :idSpectacle;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSpectacle' => $idSpectacle]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}