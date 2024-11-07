<?php

namespace iutnc\nrv\repository;

use iutnc\nrv\bd\ConnectionBD;
use PDO;

class UtilisateurRepository {
    private PDO $db;

    public function __construct() {
        $this->db = ConnectionBD::seConnecterBD();
    }

    public function ajouterUtilisateur($nomUtilisateur, $motDePasse, $role, $preferences) {
        $query = "INSERT INTO Utilisateurs (nomUtilisateur, motDePasse, role, preferences) VALUES (:nomUtilisateur, :motDePasse, :role, :preferences)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nomUtilisateur", $nomUtilisateur);
        $stmt->bindParam(":motDePasse", $motDePasse);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":preferences", $preferences);
        return $stmt->execute();
    }

    public function obtenirUtilisateurParNom($nomUtilisateur) {
        $query = "SELECT * FROM Utilisateurs WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nomUtilisateur", $nomUtilisateur);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
