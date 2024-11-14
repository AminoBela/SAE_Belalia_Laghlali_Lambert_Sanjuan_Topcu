<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\Lieu;
use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;
use PDO;
use iutnc\nrv\bd\ConnectionBD;

class SpectacleToSoireeRepository
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionBD::obtenirBD();
    }

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