<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\AdminController;
use App\Model\SocialLink;

class Update extends AdminController
{
    protected function execute(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->updateSocialLink();
            $this->redirect('/admin/social');
        }

        $this->render(
            'admin/social/form',
            [
                'socialLink' => $this->findSocialLink()
            ]
        );
    }

    protected function findSocialLink(): SocialLink
    {
        $socialLink = new SocialLink();
        $socialLink->load($this->getRequest('id'));

        return $socialLink;
    }

    protected function updateSocialLink(): void
    {
        $data = $this->getRequest()->post('social');
        
        if (!is_array($data)) {
            return;
        }
        
        $socialLink = new SocialLink();
        $socialLink->load($data['id']);
        unset($data['id']);
        
        // Handle enabled checkbox
        $data['enabled'] = isset($data['enabled']) ? 1 : 0;
        
        $socialLink->setData($data)->save();
    }
}
