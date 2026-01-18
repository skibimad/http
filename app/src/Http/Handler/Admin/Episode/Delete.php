<?php

namespace App\Http\Handler\Admin\Episode;

use App\Http\Handler\AdminController;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\Episode;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Delete extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isGet()) {
            $this->deleteEpisode($request);
        }

        return $this->redirectReferer($request);
    }

    /**
     * Retrieve a new episode instance
     *
     * @return Episode
     */
    protected function getEpisode(): Episode
    {
        return new Episode();
    }

    /**
     * Delete the episode based on request data
     *
     */
    protected function deleteEpisode(RequestInterface $request): void
    {
        $episode = new Episode();

        $episode->load($request->query('id'));
        if (!$episode->getId()) {
            throw new \Exception('Episode not found');
        }
        
        $episode->delete($request->query('id'));
    }
    
}
