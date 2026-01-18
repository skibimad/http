<?php

namespace App\Http\Handler\Admin\Episode;

use Juzdy\Config;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Model\Episode;
use App\Http\Handler\Admin\Episode\Uploader;
use App\Http\Handler\Admin\AdminHandler;

class Put extends AdminHandler
{
    

    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
            $this->putEpisode($request);

        //} catch (\Throwable) {
            return $this->redirect('/admin/episodes');
        //}
    }

    /**
     * Create a new episode based on request data
     *
     * @param RequestInterface $request
     */
    protected function putEpisode(RequestInterface $request): void
    {
        $episodeData = $request->post('episode');
        $this->assertValid($episodeData);
        $episode = new Episode();
        $episode
            ->create($episodeData);

        $episode->set('thumbnail', $this->uploadImage($episode, $request))
            ->save();

    }

    /**
     * Validate the episode data
     *
     * @param array $data
     * @return bool
     */
    protected function assertValid(array &$data)
    {
        unset($data['id']);
        return true;
    }

    protected function uploadImage(Episode$episode, RequestInterface $request): string
    {
        $uploader = new Uploader($request);
        $uploadPath = Config::get('upload_dir') . 'episode/'.$episode->getId().'/';

        $fullPath = Config::get('root') . 'public' . $uploadPath;

        $uploads = $uploader->upload('thumbnail', $fullPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return $uploadPath.$uploads[0];
    }

    
}
