<?php

namespace iutnc\nrv\repository;

use Exception;
use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\models\Spectacle;
use PDO;

/**
 * Class SpectacleRepository
 *
 * Classe pour accéder aux spectacles dans la base de données.
 *
 * @package iutnc\nrv\repository
 */
class SpectacleRepository {

    /**
     * Attribute pdo
     * @var PDO|null Instance de la connexion à la base de données.
     */
    private PDO $pdo;

    /**
     * SpectacleRepository constructor.
     */
    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    /**
     * Récupère tous les spectacles.
     * @return array La liste de tous les spectacles sous forme de tableau
     */
    public function getListeSpectacles(): array
    {
        $query = "
            SELECT s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, s.genre, so.dateSoiree, so.horraireDebut, l.nomLieu, l.adresse, i.urlImage
            FROM Spectacle s
            LEFT JOIN SoireeToSpectacle sts ON s.idSpectacle = sts.idSpectacle
            LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
            LEFT JOIN Lieu l ON so.idLieu = l.idLieu
            LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
            LEFT JOIN Image i ON its.idImage = i.idImage;
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau spectacle dans la base de données.
     * @param Spectacle $spectacle Le spectacle à ajouter.
     */
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

    /**
     * avoir un spectacle par son id
     * @param string $idSpectacle
     * @return Spectacle|null
     */
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

    /**
     * avoir la liste des spectacles par date
     * @param string $date
     * @return array
     */
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

    /**
     * avoir la liste des spectacles par genre
     * @param string $genre
     * @return array
     */
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

    /**
     * avoir la liste des spectacles par lieu
     * @param string $lieu
     * @return array
     */
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

    /**
     * avoir la date soirée
     * @return array
     */
    public function getDistinctJours(): array {
        $query = "SELECT DISTINCT dateSoiree FROM Soiree ORDER BY dateSoiree ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * avoir la liste des lieux
     * @return array
     */
    public function getDistinctLieux(): array {
        $query = "SELECT DISTINCT nomLieu FROM Lieu ORDER BY nomLieu ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * avoir la liste des styles
     * @return array
     */
    public function getDistinctStyles(): array {
        $query = "SELECT DISTINCT genre FROM Spectacle ORDER BY genre ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * annuler un spectacle en fonction de son id
     * @param int $idSpectacle
     * @return bool
     */
    public function annulerSpectacle(int $idSpectacle): bool {
        $sql = "UPDATE Spectacle SET estAnnule = 1 WHERE idSpectacle = :idSpectacle";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idSpectacle' => $idSpectacle]);
    }

    /**
     * desannuler un spectacle en fonction de son id
     * @param int $idSpectacle
     * @return bool
     */
    public function desannulerSpectacle(int $idSpectacle): bool {
        $sql = "UPDATE Spectacle SET estAnnule = 0 WHERE idSpectacle = :idSpectacle";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idSpectacle' => $idSpectacle]);
    }

    /**
     * avoir le lieu d'un spectacle en fonction de son id
     * @param int $idSpectacle
     * @return string|null
     */
    public function getLieuForSpectaclesById(int $idSpectacle): ?string {
        $query = "
        SELECT s.idSpectacle, s.titre, s.description, DATE_FORMAT(s.horrairePrevuSpectacle, '%H:%i') AS horrairePrevuSpectacle, so.dateSoiree, i.urlImage, s.genre, l.nomLieu
        FROM SoireeToSpectacle sts
        LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
        LEFT JOIN Spectacle s ON sts.idSpectacle = s.idSpectacle
        LEFT JOIN ImageToSpectacle its ON s.idSpectacle = its.idSpectacle
        LEFT JOIN Image i ON its.idImage = i.idImage
        LEFT JOIN Lieu l ON so.idLieu = l.idLieu
        WHERE l.idLieu = (
            SELECT so.idLieu
            FROM SoireeToSpectacle sts
            LEFT JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
            WHERE sts.idSpectacle = :idSpectacle
            LIMIT 1
        )
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSpectacle' => $idSpectacle]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['nomLieu'] : null;
    }

    /**
     * avoir la date d'un spectacle en fonction de son id
     * @param int $idSpectacle
     * @return string|null
     */
    public function getDateForSpectacleById(int $idSpectacle): ?string {
        $query = "
        SELECT so.dateSoiree
        FROM SoireeToSpectacle sts
        INNER JOIN Soiree so ON sts.idLieu = so.idLieu AND sts.dateSoiree = so.dateSoiree
        WHERE sts.idSpectacle = :idSpectacle
        LIMIT 1;
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSpectacle' => $idSpectacle]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier que la date existe et la retourner
        return $result ? $result['dateSoiree'] : null;
    }

    /**
     * avoir les artistes d'un spectacle en fonction de son id
     * @param int $idSpectacle
     * @return string|null
     */
    public function getArtistesForSpectacleById(int $idSpectacle): ?string {
        $query = "
        SELECT a.nomArtiste
        FROM ArtisteToSpectacle ats
        INNER JOIN Artiste a ON ats.idArtiste = a.idArtiste
        WHERE ats.idSpectacle = :idSpectacle
    ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSpectacle' => $idSpectacle]);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Si des artistes sont trouvés, les concaténer dans une chaîne, sinon retourner null
        return $result ? implode(', ', $result) : null;
    }

}