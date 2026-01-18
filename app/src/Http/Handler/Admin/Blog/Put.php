<?php
namespace App\Http\Handler\Admin\Blog;

use Juzdy\Config;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\BlogPost;

class Put extends AdminHandler
{

    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
            $this->putPost($request);

        //} catch (\Throwable) {
            return $this->redirect('/admin/blog');
        //}
        

    }

    /**
     * Create a new blog post based on request data
     *
     * @param RequestInterface $request
     */
    protected function putPost(RequestInterface $request)
    {
        $postData = $request->post('post');
        $this->assertValid($postData);
        $post = new BlogPost();
        $post
            ->create($postData);

        $post->set('image', $this->uploadImage($post, $request))
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
        unset($data['id']);
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
        $uploadPath = Config::get('path.uploads') . '/blog/posts/'.$post->getId().'/';


        $uploads = $uploader->upload('post_image', $uploadPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return $uploadPath.$uploads[0];
    }

    
}
