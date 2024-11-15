<?php
/**
 * Point d'entrée de l'application.
 */
declare(strict_types=1);

require_once '../vendor/autoload.php';


use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\dispatcher\Dispatcher;


session_start();

ConnectionBD::setConfig('../config/config.ini');

$d = new Dispatcher();
$d->run();


