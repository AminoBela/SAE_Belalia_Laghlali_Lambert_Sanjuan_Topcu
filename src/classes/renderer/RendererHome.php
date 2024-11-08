<?php

namespace iutnc\nrv\renderer;

class RendererHome extends Renderer
{
    public function render(): string
    {
        $header = $this->renderHeader('Accueil - NRV Festival');
        $footer = $this->renderFooter();

        $body = <<<HTML
        <h2>Accueil</h2>
        <p>Bienvenue sur le site du NRV Festival.</p>
        HTML;

        return $header . $body . $footer;
    }



}