<?php

declare(strict_types=1);

use iutnc\nrv\bd\ConnectionBD;
use iutnc\nrv\dispatcher\Dispatcher;

session_start();

ConnectionBD::setConfig('conf.ini');

$d = new Dispatcher();
$d->run();


