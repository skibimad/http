<?php

namespace App\Controller\Admin\Social;

use App\Controller\AdminController;
use App\Model\SocialLink;

class Delete extends AdminController
{
    public function handle(): void
    {
        $id = $this->getRequest('id');
        
        if ($id) {
            $socialLink = new SocialLink();
            $socialLink->delete((int)$id);
        }
        
        $this->redirect('/admin/social');
    }
}
