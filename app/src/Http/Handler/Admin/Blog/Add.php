<?php

namespace App\Controller\Admin\Blog;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Add extends AdminController
{
    public function handle(): void
    {
        $this->render(
            'admin/blog/post',
            [
                'post' => $this->getPost()
            ]
        );
    }
    
    protected function getPost()
    {
        return new BlogPost();
    }

    
}
