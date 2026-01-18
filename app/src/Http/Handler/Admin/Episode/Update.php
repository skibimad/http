<?php

namespace App\Http\Handler\Admin\Episode;


use Juzdy\Config;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\Episode;

class Update extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
        if ($request->isPost()) {
            $this->updateEpisode($request);
            $this->redirect('/admin/episodes');
        }

        return $this->layout(
            'skibidi/admin',
            'episode/form',
            [
                'episode' => $this->findEpisode($request)
            ]
        );
    }

    /**
     * Find the episode based on request data
     *
     * @param RequestInterface $request
     * @return Episode
     */
    protected function findEpisode(RequestInterface $request): Episode
    {
        $postData = $request('episode');
        $episode = new Episode();
        $episode->load($request('id') ?? $postData['id'] ?? null);

        return $episode;
    }

    /**
     * Update the episode based on request data
     *
     * @param RequestInterface $request
     */
    protected function updateEpisode(RequestInterface $request): void
    {
        $postData = $request('episode');
        //$id = $request('id');
        $this->assertValid($postData);
        $episode = new Episode();
        $episode->load($postData['id']);
        unset($postData['id']);
        $episode    ->setData(
            array_merge(
                $postData,
                []
            )
        )
        ->save();

        // Upload thumbnail if provided
        $thumbnailPath = $this->uploadImage($episode, $request);
        if ($thumbnailPath) {
            $episode->set('thumbnail', $thumbnailPath)->save();
        }
    }

    /**
     * Validate the episode data
     *
     * @param array $data
     * @return bool
     */
    protected function assertValid(array &$data)
    {
        return true;
    }

    /**
     * Handle image upload for the episode
     *
     * @param Episode $episode
     * @param RequestInterface $request
     * @return string
     */
    protected function uploadImage(Episode $episode, RequestInterface $request): string
    {
        $uploader = new Uploader($request);
        $uploadPath = Config::get('path.uploads') . '/episode/' . $episode->getId() . '/';

        $uploads = $uploader->upload('thumbnail', $uploadPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return '/uploads/episode/' . $episode->getId() . '/' . $uploads[0];
    }
