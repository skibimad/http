<?php

namespace App\Http\Handler\Admin;


use App\Model\BlogPost;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Index extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $blogs = (new BlogPost())->getCollection();

        return $this->layout(
            'skibidi/admin',
            'dashboard',
            [
                'blogCount' => $blogs->count(),
                'heroCount' => $this->getHeroCount(),
                'episodeCount' => $this->getEpisodeCount(),
            ],
        );
    }

    protected function getHeroCount(): int
    {
        $heroes = (new \App\Model\Hero())->getCollection();
        return $heroes->count();
    }

    protected function getEpisodeCount(): int
    {
        $episodes = (new \App\Model\Episode())->getCollection();
        return $episodes->count();
    }
}
