<?php

namespace App\Http\Handler\Admin\Hero;

use App\Http\Handler\AdminController;
use App\Model\Hero;

class Add extends AdminController
{
    protected function handleRequest(): void
    {
        $this->renderView(
            'admin/hero/form',
            [
                'hero' => $this->getHero()
            ]
        );
    }

    protected function getHero(): Hero
    {
        return new Hero();
    }
}
