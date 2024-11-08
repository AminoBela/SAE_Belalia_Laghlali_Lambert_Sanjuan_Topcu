<?php

namespace iutnc\nrv\models;

class Spectacle
{
    private int $idSpectacle;
    private string $titre;
    private string $description;
    private ?string $urlVideo;
    private ?string $urlAudio;
    private string $horairePrevuSpectacle;
    private string $genre;
    private int $dureeSpectacle;
    private int $estAnnule;
    private array $images;

    public function __construct(int $idSpectacle, string $titre, string $description, ?string $urlVideo, ?string $urlAudio, string $horairePrevuSpectacle, string $genre, int $dureeSpectacle, int $estAnnule, array $images = []) {
        $this->idSpectacle = $idSpectacle;
        $this->titre = $titre;
        $this->description = $description;
        $this->urlVideo = $urlVideo;
        $this->urlAudio = $urlAudio;
        $this->horairePrevuSpectacle = $horairePrevuSpectacle;
        $this->genre = $genre;
        $this->dureeSpectacle = $dureeSpectacle;
        $this->estAnnule = $estAnnule;
        $this->images = $images;
    }

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

    public function getIdSpectacle(): int {
        return $this->idSpectacle;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getUrlVideo(): ?string {
        return $this->urlVideo;
    }

    public function getUrlAudio(): ?string {
        return $this->urlAudio;
    }

    public function getHorairePrevuSpectacle(): string {
        return $this->horairePrevuSpectacle;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    public function getDureeSpectacle(): int {
        return $this->dureeSpectacle;
    }

    public function getDureeSpectacleText(): string {
        if ($this->dureeSpectacle < 60) {
            return $this->dureeSpectacle . " minutes";
        }

        $heures = floor($this->dureeSpectacle / 60);
        $minutes = $this->dureeSpectacle % 60;
        return "$heures h $minutes minutes";
    }

    public function getEstAnnule(): int {
        return $this->estAnnule;
    }

    public function getImages() : array
    {
        return $this->images;
    }

}