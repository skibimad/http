<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\AdminController;
use App\Model\SocialLink;

class Add extends AdminController
{
    protected function handleRequest(): void
    {
        $this->renderView(
            'admin/social/form',
            [
                'socialLink' => new SocialLink()
            ]
        );
    }
}
