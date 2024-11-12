<?php
namespace iutnc\nrv\repository;

use Exception;
use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\models\Spectacle;
use PDO;

class SpectacleRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function getListeSpectacles(): array {
        $query = "
            SELECT s.idSpectacle, s.titre, s.description, s.horrairePrevuSpectacle, so.dateSoiree, i.urlImage
            FROM Spectacle s
            LEFT JOIN SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
            LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
            LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
            LEFT JOIN Image i ON its.idImage = i.idImage;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterSpectacle(Spectacle $spectacle): void
    {
        $query = "INSERT INTO Spectacle (titre, description, urlVideo, horrairePrevuSpectacle, genre, dureeSpectacle, estAnnule, urlAudio)
                  VALUES (:titre, :description, :urlVideo, :horrairePrevuSpectacle, :genre, :dureeSpectacle, :estAnnule, :urlAudio)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':titre' => $spectacle->getTitre(),
            ':description' => $spectacle->getDescription(),
            ':urlVideo' => $spectacle->getUrlVideo(),
            ':horrairePrevuSpectacle' => $spectacle->getHorairePrevuSpectacle(),
            ':genre' => $spectacle->getGenre(),
            ':dureeSpectacle' => $spectacle->getDureeSpectacle(),
            ':estAnnule' => $spectacle->getEstAnnule(),
            ':urlAudio' => $spectacle->getUrlAudio(),
        ]);
    }

    public function obtenirSpectacleParId(string $idSpectacle) : ?Spectacle
    {
        $query = "
            SELECT *
            FROM Spectacle
            WHERE idSpectacle = :idSpectacle;
        ";
        $stmt = $this->pdo->prepare($query);
        try {
            $stmt->execute(['idSpectacle' => $idSpectacle]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // get images from ImageRepository
            $imageRep = new ImageRepository();
            $images = $imageRep->getImageDepuisSpec($idSpectacle);
            $result['images'] = $images;

            return Spectacle::fromArray($result);
        }
        catch (Exception $e) {
            return null;
        }
    }

    public function getListeSpectaclesByDate(string $date): array {
        $query = "
        SELECT s.idSpectacle, s.titre, s.description, s.horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
        FROM Spectacle s
        LEFT JOIN SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
        LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
        LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
        LEFT JOIN Image i ON its.idImage = i.idImage
        LEFT JOIN Lieu l ON so.idLieu = l.idLieu
        WHERE so.dateSoiree = :date
        ORDER BY so.dateSoiree ASC;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListeSpectaclesByGenre(string $genre): array {
        $query = "
        SELECT s.idSpectacle, s.titre, s.description, s.horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
        FROM Spectacle s
        LEFT JOIN SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
        LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
        LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
        LEFT JOIN Image i ON its.idImage = i.idImage
        LEFT JOIN Lieu l ON so.idLieu = l.idLieu
        WHERE s.genre = :genre
        ORDER BY s.genre ASC;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['genre' => $genre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListeSpectaclesByLieu(string $lieu): array {
        $query = "
        SELECT s.idSpectacle, s.titre, s.description, s.horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
        FROM Spectacle s
        LEFT JOIN SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
        LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
        LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
        LEFT JOIN Image i ON its.idImage = i.idImage
        LEFT JOIN Lieu l ON so.idLieu = l.idLieu
        WHERE l.nomLieu = :lieu
        ORDER BY l.nomLieu ASC;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['lieu' => $lieu]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistinctJours(): array {
        $query = "SELECT DISTINCT dateSoiree FROM Soiree ORDER BY dateSoiree ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getDistinctLieux(): array {
        $query = "SELECT DISTINCT nomLieu FROM Lieu ORDER BY nomLieu ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getDistinctStyles(): array {
        $query = "SELECT DISTINCT genre FROM Spectacle ORDER BY genre ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }


}

