<?php

namespace iutnc\nrv\models;

class Soiree
{

    private string $dateSoiree;
    private string $nomSoiree;
    private string $thematique;
    private string $horaireDebut;
    private string $lieu;

    public function __construct(string $dateSoiree, string $nomSoiree, string $thematique, string $horaireDebut, string $lieu) {
        $this->dateSoiree = $dateSoiree;
        $this->nomSoiree = $nomSoiree;
        $this->thematique = $thematique;
        $this->horaireDebut = $horaireDebut;
        $this->lieu = $lieu;
    }

    public function getDateSoiree(): string {
        return $this->dateSoiree;
    }

    public function getNomSoiree(): string {
        return $this->nomSoiree;
    }

    public function getThematique(): string {
        return $this->thematique;
    }

    public function getHoraireDebut(): string {
        return $this->horaireDebut;
    }

    // le lieu on l'obtient a partir de la table lieu (dans la table soiree on a juste l'id du lieu)
    public function getLieu(): string {
        return $this->lieu;
    }

    public function __toString(): string {
        return $this->nomSoiree;
    }

}