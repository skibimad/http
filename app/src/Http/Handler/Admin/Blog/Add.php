<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Add extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi/admin',
            'blog/post',
            [
                'post' => $this->getPost()
            ]
        );
    }
    
    /**
     * Retrieve a new blog post instance
     *
     * @return BlogPost
     */
    protected function getPost(): BlogPost
    {
        return new BlogPost();
    }

    
}
