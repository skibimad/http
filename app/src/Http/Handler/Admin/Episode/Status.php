<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\Episode;

class Status extends AdminController
{
    protected function execute(): void
    {
        //try {
        if ($this->getRequest()->isGet()) {
            $this->updateEpisode();
        }
        $this->redirectReferer();
    }

    protected function findEpisode()
    {
        $post = new Episode();
        $post->load($this->getRequest('id'));

        return $post;
    }

    protected function updateEpisode()
    {
        $data = [
            'id' => $this->getRequest('id'),
            'status' => $this->getRequest('status'),
        ];
        
        $this->assertValid($data);
        $post = new Episode();
        $post->load($data['id']);
        unset($data['id']);
        $post->setData(
            array_merge(
                $data,
                []
            )
        )
        ->save();

    }

    protected function assertValid(array &$data)
    {
        return isset($data['id']) && isset($data['status']);
    }

    
}
