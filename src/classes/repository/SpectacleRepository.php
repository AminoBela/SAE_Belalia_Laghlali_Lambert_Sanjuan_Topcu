<?php
namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class SpectacleRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function getListeSpectacles(): array {
        $query = "
            SELECT s.titre, s.description, s.horrairePrevuSpectacle, so.dateSoiree, i.urlImage
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

    public function ajouterSpectacle(string $titre, string $description, string $urlVideo, string $urlAudio, string $horairePrevuSpectacle, string $genre, int $dureeSpectacle, int $estAnnule): void {
        $sql = "INSERT INTO spectacle 
                (titre, description, urlVideo, urlAudio, horairePrevuSpectacle, genre, dureeSpectacle, estAnnule) 
                VALUES (:titre, :description, :urlVideo, :urlAudio, :horairePrevuSpectacle, :genre, :dureeSpectacle, :estAnnule)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':urlVideo' => $urlVideo,
            ':urlAudio' => $urlAudio,
            ':horairePrevuSpectacle' => $horairePrevuSpectacle,
            ':genre' => $genre,
            ':dureeSpectacle' => $dureeSpectacle,
            ':estAnnule' => $estAnnule
        ]);
    }
}

