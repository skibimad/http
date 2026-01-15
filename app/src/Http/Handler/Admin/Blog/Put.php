<?php

namespace App\Controller\Admin\Blog;

use App\Controller\AdminController;
use Juzdy\Config;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;

class Put extends AdminController
{
    //const UPLOAD_DIR = 'public/media/uploads/blog/';

    public function handle(): void
    {
        //try {
            $this->putPost();

        //} catch (\Throwable) {
            $this->redirect('/admin/blog');
        //}
        

    }

    protected function putPost()
    {
        $postData = $this->getRequest()->post('post');
        $this->assertValid($postData);
        $post = new BlogPost();
        $post
            ->create($postData);

        $post->set('image', $this->uploadImage($post))
            ->save();

    }

    protected function assertValid(array &$data)
    {
        unset($data['id']);
        return true;
    }

    protected function uploadImage(BlogPost $post): string
    {
        $uploader = new Uploader($this->getRequest());
        $uploadPath = Config::get('upload_dir') . 'blog/posts/'.$post->getId().'/';

        $fullPath = Config::get('root') . 'public' . $uploadPath;

        $uploads = $uploader->upload('post_image', $fullPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return $uploadPath.$uploads[0];
    }

    
}
