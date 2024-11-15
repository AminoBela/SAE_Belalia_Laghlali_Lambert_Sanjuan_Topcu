<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

/**
 * Class ImageRepository
 *
 * Classe pour accéder aux images dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class ImageRepository
{
    /**
     * @var PDO Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * ImageRepository constructor.
     */
    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Récupère les images associées à un spectacle.
     *
     * @param int $idSpectacle L'ID du spectacle.
     * @return array Les images associées au spectacle sous forme de tableau associatif.
     */
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
