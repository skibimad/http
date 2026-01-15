<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\Episode;

class Update extends AdminController
{
    protected function execute(): void
    {
        //try {
        if ($this->getRequest()->isPost()) {
            $this->updateEpisode();
            $this->redirect('/admin/episodes');
        }

        $this->render(
            'admin/episode/form',
            [
                'episode' => $this->findEpisode()
            ]
        );
    }

    protected function findEpisode()
    {
        $post = new Episode();
        $post->load($this->getRequest('id'));

        return $post;
    }

    protected function updateEpisode()
    {
        $postData = $this->getRequest('episode');
        $id = $this->getRequest('id');
        $this->assertValid($postData);
        $post = new Episode();
        $post->load($postData['id']);
        unset($postData['id']);
        $post->setData(
            array_merge(
                $postData,
                []
            )
        )
        ->save();

    }

    protected function assertValid(array &$data)
    {
        return true;
    }

    
}
