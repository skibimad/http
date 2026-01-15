<?php

namespace App\Controller\Admin\Episode;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Delete extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isGet()) {
            $this->deleteEpisode();
        }
        $this->redirectReferer();
    }

    protected function getEpisode(): Episode
    {
        return new Episode();
    }

    protected function deleteEpisode()
    {
        $episode = new Episode();

        $episode->load($this->getRequest('id'));
        if (!$episode->getId()) {
            throw new \Exception('Episode not found');
        }
        
        $episode->delete($this->getRequest('id'));
    }
    
}
