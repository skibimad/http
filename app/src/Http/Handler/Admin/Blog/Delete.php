<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Delete extends AdminController
{
    protected function execute(): void
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
