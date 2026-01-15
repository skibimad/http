<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Delete extends AdminController
{
    protected function handleRequest(): void
    {
        if ($this->request()->isGet()) {
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
