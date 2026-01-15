<?php

namespace App\Controller\Admin\Social;

use App\Controller\AdminController;
use App\Model\SocialLink;

class Put extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->createSocialLink();
            $this->redirect('/admin/social');
        }

        // Redirect if accessed via GET
        $this->redirect('/admin/social/add');
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
