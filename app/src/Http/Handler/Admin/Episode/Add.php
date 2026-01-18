<?php

namespace App\Http\Handler\Admin\Episode;


use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\Episode;

class Add extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi/admin',
            'episode/form',
            [
                'episode' => $this->getEpisode()
            ]
        );
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

    
}
