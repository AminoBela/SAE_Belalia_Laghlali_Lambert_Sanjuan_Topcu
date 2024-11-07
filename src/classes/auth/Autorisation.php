<?php

namespace iutnc\nrv\security;

class Autorisation
{

    public static function verifRole(string $role): bool
    {
        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $role) {
            return true;
        }
        return false;
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