<?php

namespace App\Controller\Admin\Episode;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Add extends AdminController
{
    public function handle(): void
    {
        $this->render(
            'admin/episode/form',
            [
                'episode' => $this->getEpisode()
            ]
        );
    }

    protected function getEpisode(): Episode
    {
        return new Episode();
    }

    
}
