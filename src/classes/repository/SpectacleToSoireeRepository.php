<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\Lieu;
use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;
use PDO;
use iutnc\nrv\bd\ConnectionBD;

/**
 * Class SpectacleToSoireeRepository
 *
 * Classe pour gérer les liaisons entre spectacles et soirées dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class SpectacleToSoireeRepository
{
    /**
     * @var PDO Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * SpectacleToSoireeRepository constructor.
     */
    public function __construct()
    {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Ajoute un spectacle à une soirée dans la base de données.
     *
     * @param Soiree $soiree La soirée à laquelle le spectacle doit être ajouté.
     * @param Spectacle $spectacle Le spectacle à ajouter.
     */
    public function ajouterSpectacleToSoiree(Soiree $soiree, Spectacle $spectacle): void
    {
        $query = "INSERT INTO SoireeToSpectacle (idLieu, dateSoiree, idSpectacle)
                  VALUES (:idLieu, :dateSoiree, :idSpectacle)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idLieu' => $soiree->getLieu()->getIdLieu(),
            ':dateSoiree' => $soiree->getDateSoiree(),
            ':idSpectacle' => $spectacle->getIdSpectacle(),
        ]);
    }
}
