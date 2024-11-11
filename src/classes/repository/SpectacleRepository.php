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
}

