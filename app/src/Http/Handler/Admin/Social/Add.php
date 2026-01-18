<?php

namespace App\Http\Handler\Admin\Social;

use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\SocialLink;

class Add extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi/admin',
            'social/form',
            [
                'socialLink' => new SocialLink()
            ]
        );
    }
}
