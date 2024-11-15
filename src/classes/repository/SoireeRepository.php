<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\models\Lieu;
use iutnc\nrv\models\Soiree;
use iutnc\nrv\models\Spectacle;
use PDO;
use iutnc\nrv\bd\ConnectionBD;

/**
 * Class SoireeRepository
 *
 * Classe pour accéder aux soirées dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class SoireeRepository
{
    /**
     * @var PDO Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * SoireeRepository constructor.
     */
    public function __construct()
    {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Ajoute une nouvelle soirée dans la base de données.
     *
     * @param Soiree $soiree La soirée à ajouter.
     */
    public function ajouterSoiree(Soiree $soiree): void
    {
        $query = "INSERT INTO Soiree (idLieu, dateSoiree, nomSoiree, thematique, horraireDebut, tarif)
              VALUES (:idLieu, :dateSoiree, :nomSoiree, :thematique, STR_TO_DATE(:horraireDebut, '%H:%i'), :tarif)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idLieu' => $soiree->getLieu()->getIdLieu(),
            ':dateSoiree' => $soiree->getDateSoiree(),
            ':nomSoiree' => $soiree->getNomSoiree(),
            ':thematique' => $soiree->getThematique(),
            ':horraireDebut' => $soiree->getHoraireDebut(),
            ':tarif' => intval($soiree->getTarif()), // Conversion du tarif en entier
        ]);
    }

    /**
     * Récupère toutes les soirées.
     *
     * @return array La liste de toutes les soirées sous forme de tableau associatif.
     */
    public function getAllSoiree(): array
    {
        $query = "SELECT s.*, l.nomLieu FROM Soiree s INNER JOIN Lieu l ON s.idLieu = l.idLieu";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $soirees = [];
        foreach ($data as $row) {
            $dateSoiree = (new \DateTime($row['dateSoiree']))->format('Y-m-d');
            $soirees[] = [
                'id' => $row['idLieu'] . '-' . $row['dateSoiree'],
                'dateSoiree' => $dateSoiree,
                'idLieu' => $row['idLieu'],
                'nomLieu' => $row['nomLieu'],
                'nomSoiree' => $row['nomSoiree'],
                'thematique' => $row['thematique'],
                'horraireDebut' => $row['horraireDebut'],
                'tarif' => $row['tarif'],
            ];
        }
        return $soirees;
    }

    /**
     * Récupère une soirée par son ID de lieu et sa date.
     *
     * @param int $idLieu L'ID du lieu.
     * @param string $dateSoiree La date de la soirée.
     * @return Soiree|null La soirée correspondante ou null si elle n'existe pas.
     */
    public function getSoireeById(int $idLieu, string $dateSoiree): ?Soiree
    {
        $query = "SELECT nomSoiree, thematique, dateSoiree, DATE_FORMAT(horraireDebut, '%H:%i') as horraireDebut, idLieu, tarif FROM Soiree WHERE idLieu = :idLieu AND dateSoiree = :dateSoiree";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idLieu', $idLieu, \PDO::PARAM_INT);
        $stmt->bindValue(':dateSoiree', (new \DateTime($dateSoiree))->format('Y-m-d'), \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Soiree(
                $data['nomSoiree'],
                $data['thematique'],
                $data['dateSoiree'],
                $data['horraireDebut'],
                $this->getLieuById($data['idLieu']),
                $data['tarif']
            );
        }

        return null;
    }

    /**
     * Récupère la liste des soirées.
     *
     * @return array La liste des soirées sous forme de tableau d'objets Soiree.
     */
    public function getListeSoirees(): array
    {
        $query = "SELECT nomSoiree, thematique, dateSoiree, DATE_FORMAT(horraireDebut, '%H:%i') as horraireDebut, idLieu, tarif FROM Soiree";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $soirees = [];
        foreach ($data as $row) {
            $soirees[] = new Soiree(
                $row['nomSoiree'],
                $row['thematique'],
                $row['dateSoiree'],
                $row['horraireDebut'],
                $this->getLieuById($row['idLieu']),
                $row['tarif']
            );
        }

        return $soirees;
    }

    /**
     * Récupère les spectacles associés à une soirée.
     *
     * @param int $idLieu L'ID du lieu.
     * @param string $dateSoiree La date de la soirée.
     * @return array La liste des spectacles associés à la soirée sous forme de tableau d'objets Spectacle.
     */
    public function getSpectaclesForSoiree(int $idLieu, string $dateSoiree): array
    {
        $query = "
            SELECT sp.* 
            FROM Spectacle sp
            INNER JOIN SoireeToSpectacle sts ON sp.idSpectacle = sts.idSpectacle
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
                (int)$row['dureeSpectacle'],       // dureeSpectacle
                (bool)$row['estAnnule']            // estAnnule (converti en booléen)
            );
        }

        return $spectacles;
    }

    /**
     * Récupère un lieu par son ID.
     *
     * @param int $idLieu L'ID du lieu.
     * @return Lieu Le lieu correspondant à l'ID fourni.
     * @throws \Exception Si le lieu n'est pas trouvé.
     */
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
