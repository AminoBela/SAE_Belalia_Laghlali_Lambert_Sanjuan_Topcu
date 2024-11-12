<?php

namespace iutnc\nrv\auth;

/**
 * Classe pour la gestion des autorisations.
 */
class Autorisation
{

    /**
     * Vérifie si l'utilisateur a le rôle attendu.
     * @param string $role Rôle attendu.
     * @return bool Vrai si l'utilisateur a le rôle attendu, faux sinon.
     */
    public static function verifRole(string $role): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_role']) && strtolower($_SESSION['user_role']) === strtolower($role);
    }

    /**
     * Vérifie si l'utilisateur est de role 'staff'.
     * @return bool
     */
    public static function isStaff(): bool
    {
        return self::verifRole('staff');
    }

    /**
     * Vérifie si l'utilisateur est de role 'admin'.
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return self::verifRole('Admin');
    }

}