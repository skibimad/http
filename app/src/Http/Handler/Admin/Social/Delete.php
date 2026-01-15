<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\AdminController;
use App\Model\SocialLink;

class Delete extends AdminController
{
    protected function handleRequest(): void
    {
        $id = $this->getRequest('id');
        
        if ($id) {
            $socialLink = new SocialLink();
            $socialLink->delete((int)$id);
        }
        
        $this->redirectTo('/admin/social');
    }
}
