<?php

namespace iutnc\nrv\repository;

use Cassandra\Date;
use DateTime;
use PDO;
use iutnc\nrv\bd\ConnectionBD;

class SoireeRepository
{

    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }

    public function chercherDateSoiree(DateTime $date): bool {
        $sql = "SELECT COUNT(*) FROM soiree WHERE dateSoiree = :date";
        $stmt = $this->pdo->prepare($sql);

        // On formate la date en string pour la requête
        $formattedDate = $date->format('Y-m-d');

        $stmt->execute(['date' => $formattedDate]);
        return $stmt->fetchColumn() > 0;
    }


    public function chercherNomSoiree(string $nomSoiree):bool {
        $sql = "SELECT COUNT(*) FROM soiree WHERE nomSoiree = :nomSoiree";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nomSoiree' => $nomSoiree]);
        return $stmt->fetchColumn() > 0;
    }

    public function chercherThematique(string $thematique):bool {
        $sql = "SELECT COUNT(*) FROM soiree WHERE thematique = :thematique";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['thematique' => $thematique]);
        return $stmt->fetchColumn() > 0;
    }

    public function chercherHoraireDebut(string $horaireDebut): bool {

        // Validation simple pour vérifier que l'heure est bien au format HH:MM:SS
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $horaireDebut)) {
            throw new InvalidArgumentException("Le format de l'horaire est invalide.");
        }

        $sql = "SELECT COUNT(*) FROM soiree WHERE horaireDebut = :horaireDebut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['horaireDebut' => $horaireDebut]);
        return $stmt->fetchColumn() > 0;
    }
}