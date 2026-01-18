<?php

namespace App\Http\Handler\Admin\Hero;


use App\Http\Handler\Admin\AdminHandler;
use App\Model\Hero;
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
            $this->deleteHero($request);
        }
        return $this->redirectReferer($request);
    }

    /**
     * Delete the hero based on request data
     *
     */
    protected function deleteHero(RequestInterface $request): void
    {
        $hero = new Hero();
        $hero->load($request->query('id'));
        
        if (!$hero->getId()) {
            throw new \Exception('Hero not found');
        }
        
        $hero->delete($hero->getId());
    }
}
