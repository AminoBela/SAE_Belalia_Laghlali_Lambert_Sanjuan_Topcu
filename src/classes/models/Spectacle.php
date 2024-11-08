<?php

namespace iutnc\nrv\models;

class Spectacle
{
    private int $idSpectacle;
    private string $titre;
    private string $description;
    private string $urlVideo;
    private string $urlAudio;
    private string $horairePrevuSpectacle;
    private string $genre;
    private int $dureeSpectacle;
    private int $estAnnule;

    public function __construct(int $idSpectacle, string $titre, string $description, string $urlVideo, string $urlAudio, string $horairePrevuSpectacle, string $genre, int $dureeSpectacle, int $estAnnule) {
        $this->idSpectacle = $idSpectacle;
        $this->titre = $titre;
        $this->description = $description;
        $this->urlVideo = $urlVideo;
        $this->urlAudio = $urlAudio;
        $this->horairePrevuSpectacle = $horairePrevuSpectacle;
        $this->genre = $genre;
        $this->dureeSpectacle = $dureeSpectacle;
        $this->estAnnule = $estAnnule;
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

    public function getUrlVideo(): string {
        return $this->urlVideo;
    }

    public function getUrlAudio(): string {
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

    public function getEstAnnule(): int {
        return $this->estAnnule;
    }


}