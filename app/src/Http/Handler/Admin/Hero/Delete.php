<?php

namespace App\Http\Handler\Admin\Hero;

use App\Http\Handler\AdminController;
use App\Model\Hero;

class Delete extends AdminController
{
    protected function handleRequest(): void
    {
        if ($this->request()->isGet()) {
            $this->deleteHero();
        }
        $this->redirectReferer();
    }

    protected function deleteHero()
    {
        $hero = new Hero();
        $hero->load($this->getRequest('id'));
        
        if (!$hero->getId()) {
            throw new \Exception('Hero not found');
        }
        
        $hero->delete($hero->getId());
    }
}
