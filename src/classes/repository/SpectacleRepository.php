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

    public function getListeSpectacles(): array
    {
        $query = "
            select s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, s.genre, so.dateSoiree, so.horraireDebut, l.nomLieu, l.adresse, i.urlImage
            from Spectacle s
            left join SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
            left join Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
            left join Lieu l ON so.idLieu = l.idLieu
            left join ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
                left join Image i ON its.idImage = i.idImage;
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterSpectacle(Spectacle $spectacle): void
    {
        $query = "insert into Spectacle (titre, description, urlVideo, urlAudio, horrairePrevuSpectacle, genre, dureeSpectacle, estAnnule) 
        values (:titre, :description, :urlVideo, :urlAudio, :horrairePrevuSpectacle, :genre, :dureeSpectacle, :estAnnule)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'titre' => $spectacle->getTitre(),
            'description' => $spectacle->getDescription(),
            'urlVideo' => $spectacle->getUrlVideo(),
            'urlAudio' => $spectacle->getUrlAudio(),
            'horrairePrevuSpectacle' => $spectacle->getHorairePrevuSpectacle(),
            'genre' => $spectacle->getGenre(),
            'dureeSpectacle' => $spectacle->getDureeSpectacle(),
            'estAnnule' => $spectacle->getEstAnnule()
        ]);
    }

    public function obtenirSpectacleParId(string $idSpectacle) : ?Spectacle
    {
        $query = "select s.*, i.urlImage
        from Spectacle s   
        left join ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
        left join Image i ON its.idImage = i.idImage
        where s.idSpectacle = :idSpectacle";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSpectacle' => $idSpectacle]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $spectacle = Spectacle::fromArray($result[0]);
            $images = array_column($result, 'urlImage');
            $spectacle->setImages($images);
            return $spectacle;
        }

        return null;
    }

    public function getListeSpectaclesByDate(string $date): array {
        $query = "
        SELECT s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
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
        SELECT s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
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
        SELECT s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
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


    public function annulerSpectacle(int $idSpectacle): bool {
        $sql = "UPDATE Spectacle SET estAnnule = TRUE WHERE idSpectacle = :idSpectacle";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':idSpectacle' => $idSpectacle]);
    }

}

