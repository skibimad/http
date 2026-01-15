<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\AdminController;
use App\Model\SocialLink;

class Put extends AdminController
{
    protected function handleRequest(): void
    {
        if ($this->request()->isPost()) {
            $this->createSocialLink();
            $this->redirectTo('/admin/social');
        }

        // Redirect if accessed via GET
        $this->redirectTo('/admin/social/add');
    }

    protected function createSocialLink(): void
    {
        $data = $this->getRequest()->post('social');
        
        if (!is_array($data)) {
            return;
        }
        
        unset($data['id']);
        
        // Handle enabled checkbox
        $data['enabled'] = isset($data['enabled']) ? 1 : 0;
        
        $socialLink = new SocialLink();
        $socialLink->setData($data)->save();
    }
}
