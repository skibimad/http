<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Update extends AdminController
{
    protected function handleRequest(): void
    {
        //try {
        if ($this->getRequest()->isPost()) {
            $this->updatePost();
            $this->redirect('/admin/blog');
        }

        $this->render(
            'admin/blog/post',
            [
                'post' => $this->findPost()
            ]
        );
    }

    protected function findPost()
    {
        $post = new BlogPost();
        $post->load($this->getRequest('id'));

        return $post;
    }

    protected function updatePost()
    {
        $postData = $this->getRequest('post');
        $id = $this->getRequest('id');
        $this->assertValid($postData);
        $post = new BlogPost();
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
