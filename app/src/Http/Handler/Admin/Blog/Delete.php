<?php

namespace App\Controller\Admin\Blog;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Delete extends AdminController
{
    public function handle(): void
    {
        //try {
            $this->deletePost();

        //} catch (\Throwable) {
            $this->redirect('/admin/blog');
        //}


    }

    protected function deletePost()
    {
        $postId = $this->getRequest()->query('id');
        $post = new BlogPost();
        $post->delete($postId);

    }

    protected function assertValid(array $data)
    {
        return true;
    }

    
}
