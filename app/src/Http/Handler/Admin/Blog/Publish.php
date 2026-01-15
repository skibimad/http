<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Publish extends AdminController
{
    protected function handleRequest(): void
    {
        //try {
            $this->publishPost();

        //} catch (\Throwable) {
            $this->redirectReferer();
        //}


    }

    protected function publishPost()
    {
        $postId = $this->getRequest()->query('id');
        $post = new BlogPost();
        $post->load($postId);
        $post->publish();

    }

    protected function assertValid(array $data)
    {
        return true;
    }

    
}
