<?php

namespace iutnc\nrv\dispatcher;

class Dispatcher
{

    private string $action;

    public function __construct()
    {
        $this->action = "";
        if (isset($_GET['action'])) $this->action = $_GET['action'];
    }

    public function run()
    {
        switch ($this->action) {
            default:
                echo "default";
                break;
        }
    }


}