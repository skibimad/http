<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Publish extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
            $this->publishPost($request('id'));

        //} catch (\Throwable) {
            return $this->redirect('/admin/blog');
        //}


    }

    /**
     * Publish the blog post based on request data
     *
     * @param int $postId
     */
    protected function publishPost(int $postId)
    {
        $post = new BlogPost();
        $post->load($postId);
        $post->publish();

    }

    /**
     * Validate the blog post data
     *
     * @param array $data
     * @return bool
     */
    protected function assertValid(array $data)
    {
        return true;
    }

    
}
