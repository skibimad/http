<?php
namespace App\Http\Handler\Admin\Hero;


use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\Hero;

class Add extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi/admin',
            'hero/form',
            [
                'hero' => $this->getHero()
            ]
        );
    }

    /**
     * Retrieve a new hero instance
     *
     * @return Hero
     */
    protected function getHero(): Hero
    {
        return new Hero();
    }
}
