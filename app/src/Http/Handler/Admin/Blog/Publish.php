<?php

namespace App\Controller\Admin\Blog;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Publish extends AdminController
{
    public function handle(): void
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
