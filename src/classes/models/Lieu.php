<?php

namespace iutnc\nrv\models;

class Lieu
{
    private int $idLieu;
    private string $nomLieu;
    private string $adresse;
    private int $nombrePlacesAssises;
    private int $nombrePlacesDebout;

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

    public function getIdLieu(): int { return $this->idLieu; }
    public function getNomLieu(): string { return $this->nomLieu; }
    public function getAdresse(): string { return $this->adresse; }
    public function getNombrePlacesAssises(): int { return $this->nombrePlacesAssises; }
    public function getNombrePlacesDebout(): int { return $this->nombrePlacesDebout; }

    public function __toString(): string
    {
        return "{$this->nomLieu}, {$this->adresse} (Assises: {$this->nombrePlacesAssises}, Debout: {$this->nombrePlacesDebout})";
    }
}
