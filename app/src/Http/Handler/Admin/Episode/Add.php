<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Add extends AdminController
{
    protected function handleRequest(): void
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
