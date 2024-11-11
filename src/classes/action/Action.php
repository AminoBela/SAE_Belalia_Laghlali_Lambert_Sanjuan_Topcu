<?php

namespace iutnc\nrv\action;

/**
 * Classe abstraite Action
 *
 * Cette classe abstraite définit les propriétés et méthodes communes à toutes les actions.
 */
abstract class Action  {

    /**
     * Attributs
     * @var string|mixed|null $http_method Attrubut qui contient la méthode HTTP utilisée
     * @var string|mixed|null $hostname Attribut qui contient le nom de domaine
     * @var string|mixed|null $script_name Attribut qui contient le chemin du script
     */
    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;

    /**
     * Constructeur
     * Ce constructeur initialise les attributs de la classe Action.
     */
    public function __construct(){

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    /**
     * Méthode abstraite execute
     * @return string Retourne le résultat de l'action
     */
    abstract public function execute() : string;

}