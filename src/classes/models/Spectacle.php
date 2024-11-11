<?php

namespace iutnc\nrv\models;

/**
 * Classe pour la gestion des spectacles.
 */
class Spectacle
{

    /**
     * Attributs de la classe.
     * @var int $idSpectacle Identifiant du spectacle.
     * @var string $titre Titre du spectacle.
     * @var string $description Description du spectacle.
     * @var string $urlVideo URL de la vidéo du spectacle.
     * @var string $urlAudio URL de l'audio du spectacle.
     * @var string $horairePrevuSpectacle Horaire prévu du spectacle.
     * @var string $genre Genre du spectacle.
     * @var int $dureeSpectacle Durée du spectacle.
     * @var int $estAnnule Si le spectacle est annulé.
     * @var array $images Images du spectacle.
     */
    private ?int $idSpectacle;
    private string $titre;
    private string $description;
    private ?string $urlVideo = null;
    private ?string $urlAudio = null;
    private string $horairePrevuSpectacle;
    private string $genre;
    private int $dureeSpectacle;
    private int $estAnnule;
    private array $images;

    /**
     * Constructeur de la classe.
     * @param int|null $idSpectacle
     * @param string $titre
     * @param string $description
     * @param string|null $urlVideo
     * @param string|null $urlAudio
     * @param string $horairePrevuSpectacle
     * @param string $genre
     * @param int $dureeSpectacle
     * @param int $estAnnule
     * @param array $images
     */
    public function __construct(?int $idSpectacle, string $titre, string $description, ?string $urlVideo, ?string $urlAudio, string $horairePrevuSpectacle, string $genre, int $dureeSpectacle, int $estAnnule, array $images = []) {
        $this->idSpectacle = $idSpectacle;
        $this->titre = $titre;
        $this->description = $description;
        $this->urlVideo = $urlVideo ;
        $this->urlAudio = $urlAudio;
        $this->horairePrevuSpectacle = $horairePrevuSpectacle;
        $this->genre = $genre;
        $this->dureeSpectacle = $dureeSpectacle;
        $this->estAnnule = $estAnnule;
        $this->images = $images;
    }

    /**
     * Crée un spectacle à partir d'un tableau.
     * @param $result Tableau contenant les informations du spectacle.
     * @return Spectacle Spectacle créé.
     */
    public static function fromArray($result) : Spectacle
    {
        $images = $result['images'] ?? [];

        return new Spectacle(
            $result['idSpectacle'],
            $result['titre'],
            $result['description'],
            $result['urlVideo'],
            $result['urlAudio'],
            $result['horrairePrevuSpectacle'],
            $result['genre'],
            $result['dureeSpectacle'],
            $result['estAnnule'],
            $images
        );
    }

    /**
     * Getter de l'id du spectacle.
     * @return int
     */
    public function getIdSpectacle(): int {
        return $this->idSpectacle;
    }

    /***
     * Getter du titre du spectacle.
     * @return string
     */
    public function getTitre(): string {
        return $this->titre;
    }

    /**
     * Getter de la description du spectacle.
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Getter de l'url de la vidéo du spectacle.
     * @return string|null
     */
    public function getUrlVideo(): ?string {
        return $this->urlVideo;
    }

    /**
     * Getter de l'url de l'audio du spectacle.
     * @return string|null
     */
    public function getUrlAudio(): ?string {
        return $this->urlAudio;
    }

    /**
     * Getter de l'horaire prévu du spectacle.
     * @return string
     */
    public function getHorairePrevuSpectacle(): string {
        return $this->horairePrevuSpectacle;
    }

    /**
     * Getter du genre du spectacle.
     * @return string
     */
    public function getGenre(): string {
        return $this->genre;
    }

    /**
     * Getter de la durée du spectacle.
     * @return int
     */
    public function getDureeSpectacle(): int {
        return $this->dureeSpectacle;
    }

    /**
     * Getter de la durée du spectacle sous forme de texte.
     * @return string
     */
    public function getDureeSpectacleText(): string {
        if ($this->dureeSpectacle < 60) {
            return $this->dureeSpectacle . " minutes";
        }

        $heures = floor($this->dureeSpectacle / 60);
        $minutes = $this->dureeSpectacle % 60;
        return "$heures h $minutes minutes";
    }

    /**
     * Getter de l'attribut estAnnule.
     * @return int
     */
    public function getEstAnnule(): int {
        return $this->estAnnule;
    }

    /**
     * Getter des images du spectacle.
     * @return array
     */
    public function getImages() : array
    {
        return $this->images;
    }

}