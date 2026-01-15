<?php

namespace App\Controller\Admin\Hero;

use App\Controller\AdminController;
use App\Model\Hero;

class Delete extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isGet()) {
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
