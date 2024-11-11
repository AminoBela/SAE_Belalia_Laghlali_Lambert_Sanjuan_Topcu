<?php

namespace iutnc\nrv\models;

use iutnc\nrv\models\Lieu;
use iutnc\nrv\models\Spectacle;

class Soiree
{
    private string $nomSoiree;      // Nom de la soirée
    private string $thematique;    // Thématique générale (ex. "soirée blues")
    private string $dateSoiree;    // Date de la soirée
    private string $horaireDebut;  // Horaire de début
    private Lieu $lieu;            // Lieu où se déroule la soirée
    private array $spectacles;     // Liste des spectacles prévus

    public function __construct(
        string $nomSoiree,
        string $thematique,
        string $dateSoiree,
        string $horaireDebut,
        Lieu $lieu,
        array $spectacles = [] // Spectacles associés (par défaut vide)
    ) {
        $this->nomSoiree = $nomSoiree;
        $this->thematique = $thematique;
        $this->dateSoiree = $dateSoiree;
        $this->horaireDebut = $horaireDebut;
        $this->lieu = $lieu;
        $this->spectacles = $spectacles;
    }

    // Getters
    public function getNomSoiree(): string { return $this->nomSoiree; }
    public function getThematique(): string { return $this->thematique; }
    public function getDateSoiree(): string { return $this->dateSoiree; }
    public function getHoraireDebut(): string { return $this->horaireDebut; }
    public function getLieu(): Lieu { return $this->lieu; }
    public function getSpectacles(): array { return $this->spectacles; }

    // Setters
    public function setSpectacles(array $spectacles): void { $this->spectacles = $spectacles; }

    public function __toString(): string
    {
        return "{$this->nomSoiree} - {$this->thematique} ({$this->dateSoiree}, {$this->horaireDebut} au {$this->lieu})";
    }


}
