<?php

namespace App\Http\Handler\Admin\Blog;

use Juzdy\Config;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\Blog\Uploader;

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

        // Upload image if provided
        $imagePath = $this->uploadImage($post, $request);
        if ($imagePath) {
            $post->set('image', $imagePath)->save();
        }
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

    /**
     * Handle image upload for the blog post
     *
     * @param BlogPost $post
     * @param RequestInterface $request
     * @return string
     */
    protected function uploadImage(BlogPost $post, RequestInterface $request): string
    {
        $uploader = new Uploader($request);
        $uploadPath = Config::get('path.uploads') . '/blog/posts/' . $post->getId() . '/';

        $uploads = $uploader->upload('post_image', $uploadPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return '/uploads/blog/posts/' . $post->getId() . '/' . $uploads[0];
    }
