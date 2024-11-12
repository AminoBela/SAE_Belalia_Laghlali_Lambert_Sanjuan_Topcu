<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\Lieu;
use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;
use PDO;
use iutnc\nrv\bd\ConnectionBD;

class SoireeRepository
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function ajouterSoiree(Soiree $soiree): void
    {
        $query = "INSERT INTO Soiree (idLieu, dateSoiree, nomSoiree, thematique, horraireDebut)
                  VALUES (:idLieu, :dateSoiree, :nomSoiree, :thematique, :horraireDebut)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idLieu' => $soiree->getLieu()->getIdLieu(),
            ':dateSoiree' => $soiree->getDateSoiree(),
            ':nomSoiree' => $soiree->getNomSoiree(),
            ':thematique' => $soiree->getThematique(),
            ':horraireDebut' => $soiree->getHoraireDebut(),
        ]);
    }

    public function getSoireeById(int $idLieu, string $dateSoiree): ?Soiree
    {
        $query = "SELECT * FROM Soiree WHERE idLieu = :idLieu AND dateSoiree = :dateSoiree";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idLieu', $idLieu, \PDO::PARAM_INT);
        $stmt->bindValue(':dateSoiree', $dateSoiree, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Soiree(
                $data['nomSoiree'],
                $data['thematique'],
                $data['dateSoiree'],
                $data['horraireDebut'],
                $this->getLieuById($data['idLieu'])
            );
        }

        return null;
    }


    public function getSpectaclesForSoiree(int $idLieu, string $dateSoiree): array
    {
        $query = "
        SELECT sp.* 
        FROM Spectacle sp
        INNER JOIN SoireeToSpectacle sts
        ON sp.idSpectacle = sts.idSpectacle
        WHERE sts.idLieu = :idLieu AND sts.dateSoiree = :dateSoiree
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idLieu', $idLieu, \PDO::PARAM_INT);
        $stmt->bindValue(':dateSoiree', $dateSoiree, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $spectacles = [];
        foreach ($data as $row) {
            $spectacles[] = new Spectacle(
                $row['idSpectacle'],                // idSpectacle (int ou null)
                $row['titre'],                     // titre
                $row['description'],               // description
                $row['urlVideo'] ?? null,          // urlVideo (peut être null)
                $row['urlAudio'] ?? null,          // urlAudio (peut être null)
                $row['horrairePrevuSpectacle'],    // horrairePrevuSpectacle
                $row['genre'],                     // genre
                (int) $row['dureeSpectacle'],      // dureeSpectacle
                (bool) $row['estAnnule']           // estAnnule (converti en booléen)
            );
        }

        return $spectacles;
    }




    public function getLieuById(int $idLieu): Lieu
    {
        $query = "SELECT * FROM Lieu WHERE idLieu = :idLieu";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idLieu', $idLieu, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Lieu(
                $data['idLieu'],
                $data['nomLieu'],
                $data['adresse'],
                $data['nombrePlacesAssises'],
                $data['nombrePlacesDebout']
            );
        }

        throw new \Exception("Lieu introuvable pour l'ID $idLieu");
    }


}