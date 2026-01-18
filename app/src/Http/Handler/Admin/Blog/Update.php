<?php

namespace App\Http\Handler\Admin\Blog;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Update extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
        if ($request->isPost()) {
            $this->updatePost($request);
            return $this->redirect('/admin/blog');
        }

        return $this->layout(
            'skibidi/admin',
            'blog/post',
            [
                'post' => $this->findPost($request)
            ]
        );
    }

    /**
     * Find the blog post based on request data
     *
     * @param RequestInterface $request
     * @return BlogPost
     */
    protected function findPost(RequestInterface $request): BlogPost
    {
        $post = new BlogPost();
        $post->load($request('id'));

        return $post;
    }

    /**
     * Update the blog post based on request data
     *
     * @param RequestInterface $request
     */
    protected function updatePost(RequestInterface $request): void
    {
        $postData = $request('post');
        $id = $request('id');

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

    /**
     * Validate the blog post data
     *
     * @param array $data
     * @return bool
     */
    protected function assertValid(array &$data)
    {
        return true;
    }

    
}
