<?php

namespace iutnc\nrv\auth;

class Autorisation
{

    public static function verifRole(string $role): bool
    {
        // Vérifie si la session est active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si le rôle dans la session correspond au rôle attendu
        return isset($_SESSION['user_role']) && strtolower($_SESSION['user_role']) === strtolower($role);
    }



    public static function isStaff(): bool
    {
        return self::verifRole('staff');
    }

    public static function isAdmin(): bool
    {
        return self::verifRole('Admin');
    }

}