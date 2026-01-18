<?php

namespace App\Http\Handler\Admin\Episode;


use Juzdy\Http\RequestInterface;
use App\Model\Episode;
use App\Http\Handler\Admin\AdminHandler;
use Juzdy\Http\ResponseInterface;

class Status extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        //try {
        if ($request->isGet()) {
            $this->updateEpisode($request);
        }

        return $this->redirectReferer($request);
    }

    protected function findEpisode(RequestInterface $request): Episode
    {
        $post = new Episode();
        $post->load($request('id'));

        return $post;
    }

    /**
     * Update the episode based on request data
     *
     * @param RequestInterface $request
     */
    protected function updateEpisode(RequestInterface $request): void
    {
        $data = [
            'id' => $request('id'),
            'status' => $request('status'),
        ];
        
        $this->assertValid($data);
        $post = new Episode();
        $post->load($data['id']);
        unset($data['id']);
        $post->setData(
            array_merge(
                $data,
                []
            )
        )
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
        return isset($data['id']) && isset($data['status']);
    }

    
}
