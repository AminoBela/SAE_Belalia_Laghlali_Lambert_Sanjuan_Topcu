<?php

namespace iutnc\nrv\models;

/**
 * Classe pour la gestion des soirées.
 */
class Soiree
{

    /**
     * Attributs de la classe.
     * @var string $nomSoiree Nom de la soirée.
     * @var string $thematique Thématique de la soirée.
     * @var string $dateSoiree Date de la soirée.
     * @var string $horaireDebut Horaire de début de la soirée.
     * @var Lieu $lieu Lieu de la soirée.
     * @var array $spectacles Spectacles de la soirée.
     */
    private string $nomSoiree;
    private string $thematique;
    private string $dateSoiree;
    private string $horaireDebut;
    private Lieu $lieu;
    private array $spectacles;

    private int $tarif;

    /**
     * Constructeur de la classe.
     * @param string $nomSoiree Nom de la soirée.
     * @param string $thematique Thématique de la soirée.
     * @param string $dateSoiree Date de la soirée.
     * @param string $horaireDebut Horaire de début de la soirée.
     * @param Lieu $lieu Lieu de la soirée.
     * @param array $spectacles Spectacles de la soirée.
     */
    public function __construct(
        string $nomSoiree,
        string $thematique,
        string $dateSoiree,
        string $horaireDebut,
        Lieu $lieu,
        int $tarif,
        array $spectacles = []
    ) {
        $this->nomSoiree = $nomSoiree;
        $this->thematique = $thematique;
        $this->dateSoiree = $dateSoiree;
        $this->horaireDebut = $horaireDebut;
        $this->lieu = $lieu;
        $this->spectacles = $spectacles;
        $this->tarif = $tarif;
    }

    /**
     * Getter du nom de la soirée.
     * @return string Nom de la soirée.
     */
    public function getNomSoiree(): string
    {
        return $this->nomSoiree;
    }

    /**
     * Getter de la thématique de la soirée.
     * @return string Thématique de la soirée.
     */
    public function getThematique(): string
    {
        return $this->thematique;
    }

    /**
     * Getter de la date de la soirée.
     * @return string Date de la soirée.
     */
    public function getDateSoiree(): string
    {
        return $this->dateSoiree;
    }

    /**
     * Getter de l'horaire de début de la soirée.
     * @return string Horaire de début de la soirée.
     */
    public function getHoraireDebut(): string
    {
        return $this->horaireDebut;
    }

    /**
     * Getter du lieu de la soirée.
     * @return Lieu Lieu de la soirée.
     */
    public function getLieu(): Lieu
    {
        return $this->lieu;
    }

    /**
     * Getter des Spectacles.
     * @return array
     */
    public function getSpectacles(): array
    {
        return $this->spectacles;
    }

    /**
     * @return int
     */
    public function getTarif(): int
    {
        return $this->tarif;
    }

    /**
     * Setter des Spectacles.
     * @param array $spectacles
     * @return void
     */
    public function setSpectacles(array $spectacles): void
    {
        $this->spectacles = $spectacles;
    }

    /**
     * Methode toString pour afficher une soirée.
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->nomSoiree} - {$this->thematique} ({$this->dateSoiree}, {$this->horaireDebut} au {$this->lieu})";
    }
}
