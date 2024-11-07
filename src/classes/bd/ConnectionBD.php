<?php

namespace iutnc\nrv\bd;

use PDO;
use PDOException;

class ConnectionBD
{
    private static array $tab = [];

    public static ?PDO $pdo = null;

    public static function setConfig(string $file): void
    {
        self::$tab = parse_ini_file($file);
    }

    public static function obtenirBD(): ?PDO
    {
        if(is_null(self::$pdo)){
            try {
                $res = self::$tab['driver'] . ':host=' . self::$tab['host'] . ';dbname=' . self::$tab['dbname'];
                self::$pdo = new PDO($res, self::$tab['user'], self::$tab['password']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connexion échouée à la base de données : ' . $e->getMessage();
            }
        }
        return self::$pdo;
    }

}