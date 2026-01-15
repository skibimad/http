<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Add extends AdminController
{
    protected function execute(): void
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
