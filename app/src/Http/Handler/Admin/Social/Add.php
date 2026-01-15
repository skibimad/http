<?php

namespace App\Controller\Admin\Social;

use App\Controller\AdminController;
use App\Model\SocialLink;

class Add extends AdminController
{
    public function handle(): void
    {
        $this->render(
            'admin/social/form',
            [
                'socialLink' => new SocialLink()
            ]
        );
    }
}
