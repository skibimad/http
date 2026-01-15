<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\Admin\Episode\Uploader;
use App\Http\Handler\AdminController;
use Juzdy\Config;
use App\Model\Episode;

class Put extends AdminController
{
    //const UPLOAD_DIR = 'public/media/uploads/episode/';

    protected function handleRequest(): void
    {
        //try {
            $this->putEpisode();

        //} catch (\Throwable) {
            $this->redirectTo('/admin/episodes');
        //}
        

    }

    protected function putEpisode()
    {
        $episodeData = $this->getRequest()->post('episode');
        $this->assertValid($episodeData);
        $episode = new Episode();
        $episode
            ->create($episodeData);

        $episode->set('thumbnail', $this->uploadImage($episode))
            ->save();

    }

    protected function assertValid(array &$data)
    {
        unset($data['id']);
        return true;
    }

    protected function uploadImage(Episode$episode): string
    {
        $uploader = new Uploader($this->getRequest());
        $uploadPath = Config::get('upload_dir') . 'episode/'.$episode->getId().'/';

        $fullPath = Config::get('root') . 'public' . $uploadPath;

        $uploads = $uploader->upload('thumbnail', $fullPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return $uploadPath.$uploads[0];
    }

    
}
