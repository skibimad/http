<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\AdminController;
use App\Model\SocialLink;

class Add extends AdminController
{
    protected function execute(): void
    {
        $this->render(
            'admin/social/form',
            [
                'socialLink' => new SocialLink()
            ]
        );
    }
}
