<?php

namespace iutnc\nrv\repository;

use PDO;
use iutnc\nrv\bd\ConnectionBD;

class SpectacleRepository
{

    private PDO $pdo;

    public function __construct() {
        $this->pdo = ConnectionBD::obtenirBD();
    }



}