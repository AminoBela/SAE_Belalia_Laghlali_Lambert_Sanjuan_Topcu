<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\models\Lieu;
use PDO;

/**
 * Class LieuRepository
 *
 * Classe pour accéder aux lieux dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class LieuRepository {
    /**
     * @var PDO Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * LieuRepository constructor.
     */
    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Récupère tous les lieux.
     *
     * @return array La liste de tous les lieux sous forme de tableau associatif.
     */
    public function getAllLieux(): array {
        $query = "SELECT idLieu, nomLieu FROM Lieu";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un lieu par son ID.
     *
     * @param int $idLieu L'ID du lieu.
     * @return Lieu|null Le lieu correspondant à l'ID fourni ou null s'il n'existe pas.
     */
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
