<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Delete extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
            $this->deletePost($request);
            return $this->redirect('/admin/blog');
    }

    /**
     * Delete the blog post based on request data
     *
     * @param RequestInterface $request
     */
    protected function deletePost(RequestInterface $request)
    {
        $postId = $request('id');
        $post = new BlogPost();
        $post->delete($postId);

    }
}
