<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererHome;

class HomeAction extends Action
{
    public function execute(): string
    {
        $renderer = new RendererHome();
        return $renderer->render();
    }
}