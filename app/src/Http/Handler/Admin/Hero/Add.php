<?php

namespace App\Controller\Admin\Hero;

use App\Controller\AdminController;
use App\Model\Hero;

class Add extends AdminController
{
    public function handle(): void
    {
        $this->render(
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
