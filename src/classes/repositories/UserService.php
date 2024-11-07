<?php

namespace iutnc\nrv\services;

use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\repository\User;
use PDO;

abstract class UserService
{
    public static function ajouterUtilisateur(User $user) : bool {
        $db = ConnectionBD::obtenirBD();

        $query = "INSERT INTO Utilisateurs (nomUtilisateur, motDePasse, role) VALUES (:nomUtilisateur, :motDePasse, :role)";
        $stmt = $db->prepare($query);

        $nomUtilisateur = $user->getNomUtilisateur();
        $stmt->bindParam(":nomUtilisateur", $nomUtilisateur);

        $motDePasse = $user->getPassword();
        $stmt->bindParam(":motDePasse", $motDePasse);

        $role = $user->getRole();
        $stmt->bindParam(":role", $role);

        return $stmt->execute();
    }

    public static function obtenirUtilisateurParNom($nomUtilisateur) {
        $db = ConnectionBD::obtenirBD();

        $query = "SELECT * FROM Utilisateurs WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":nomUtilisateur", $nomUtilisateur);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}