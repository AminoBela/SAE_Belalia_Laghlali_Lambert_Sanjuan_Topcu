<?php

namespace iutnc\nrv\models;

/**
 * Classe pour la gestion des lieux.
 */
class Lieu
{

    /**
     * Attributs de la classe.
     * @var int $idLieu Identifiant du lieu.
     * @var string $nomLieu Nom du lieu.
     * @var string $adresse Adresse du lieu.
     * @var int $nombrePlacesAssises Nombre de places assises.
     * @var int $nombrePlacesDebout Nombre de places debout.
     *
     */
    private int $idLieu;
    private string $nomLieu;
    private string $adresse;
    private int $nombrePlacesAssises;
    private int $nombrePlacesDebout;


    /**
     * Constructeur de la classe.
     * @param int $idLieu Identifiant du lieu.
     * @param string $nomLieu Nom du lieu.
     * @param string $adresse Adresse du lieu.
     * @param int $nombrePlacesAssises Nombre de places assises.
     * @param int $nombrePlacesDebout Nombre de places debout.
     */
    public function __construct(
        int $idLieu,
        string $nomLieu,
        string $adresse,
        int $nombrePlacesAssises,
        int $nombrePlacesDebout
    ) {
        $this->idLieu = $idLieu;
        $this->nomLieu = $nomLieu;
        $this->adresse = $adresse;
        $this->nombrePlacesAssises = $nombrePlacesAssises;
        $this->nombrePlacesDebout = $nombrePlacesDebout;
    }

    /**
     * Getter de l'id du lieu.
     * @return int Identifiant du lieu.
     */
    public function getIdLieu(): int
    {
        return $this->idLieu;
    }

    /**
     * Getter du nom du lieu.
     * @return string Nom du lieu.
     */
    public function getNomLieu(): string
    {
        return $this->nomLieu;
    }

    /**
     * Getter de l'adresse du lieu.
     * @return string Adresse du lieu.
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Getter du nombre de places assises.
     * @return int Nombre de places assises.
     */
    public function getNombrePlacesAssises(): int
    {
        return $this->nombrePlacesAssises;
    }

    /**
     * Getter du nombre de places debout.
     * @return int Nombre de places debout.
     */
    public function getNombrePlacesDebout(): int
    {
        return $this->nombrePlacesDebout;
    }

    /**
     * Méthode pour obtenir une représentation textuelle du lieu.
     * @return string Représentation textuelle du lieu.
     */
    public function __toString(): string
    {
        return "{$this->nomLieu}, {$this->adresse} (Assises: {$this->nombrePlacesAssises}, Debout: {$this->nombrePlacesDebout})";
    }
}
