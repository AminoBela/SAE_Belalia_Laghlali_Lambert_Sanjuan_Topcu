<?php

namespace iutnc\nrv\repository;

class PreferencesRepository
{
    private static PreferencesRepository $instance;

    public static function getInstance(): PreferencesRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new PreferencesRepository();
        }
        return self::$instance;
    }

    private array $spectaclePref;

    private function __construct()
    {
        // récupérer les cookies
        $cookie = $_COOKIE['spectaclePref'] ?? '{}';
        if (is_array($cookie)) {
            $cookie = '{}';
        }
        $this->spectaclePref = json_decode($cookie, true);
    }

    public function estAjouterPref(string $idSpectacle)
    {
        return in_array($idSpectacle, $this->spectaclePref);
    }

    public function togglePref(string $idSpectacle)
    {
        if ($this->estAjouterPref($idSpectacle)) {
            //supprimer l'id du spectacle dans le tableau spectaclePref
            $this->spectaclePref = array_diff($this->spectaclePref, [$idSpectacle]);
        } else {
            //ajouter l'id du spectacle dans le tableau spectaclePref sans ajouter true
            $this->spectaclePref[] = $idSpectacle;
        }
        setcookie('spectaclePref', json_encode($this->spectaclePref), time() + 3600 * 24 * 365, '/');
    }

    public function getSpectaclesIdsPref(): array
    {
        return $this->spectaclePref;
    }

}