<?php

namespace iutnc\nrv\bd;

use PDO;
use PDOException;

/**
 * Classe pour la connexion à la base de données.
 */
class ConnectionBD
{

    /**
     * Tableau de configuration et connexion à la base de données.
     * @var array
     * @var PDO
     */
    private static array $tab = [];
    public static ?PDO $bd = null;

    /**
     * Charge la configuration de la base de données.
     * @param string $file Fichier de configuration.
     */
    public static function setConfig(String $file ){
        self::$tab = parse_ini_file($file);
    }

    /**
     * Retourne la connexion à la base de données.
     * @return PDO
     */
    public static function obtenirBD()
    {
        if(is_null(self::$bd)){
            try{
                $res = self::$tab['driver'].":host=".self::$tab['host'].";dbname=".self::$tab['database'];
                self::$bd = new PDO($res, self::$tab['username'], self::$tab['password']);
                self::$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : ".$e->getMessage();
            }
        }
        return self::$bd;
    }

}