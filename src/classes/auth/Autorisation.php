<?php

namespace iutnc\nrv\auth;

class Autorisation
{

    public static function verifRole(string $role): bool
    {
        // verifier si l'utilisateur est staff ou admin
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