<?php

namespace App\Http\Handler\Admin\Social;

use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\SocialLink;

class Put extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isPost()) {
            $this->createSocialLink($request);
            return $this->redirect('/admin/social');
        }

        // Redirect if accessed via GET
        return $this->redirect('/admin/social/add');
    }

    /**
     * Create a new social link from request data
     *
     * @param RequestInterface $request
     * @return void
     */
    protected function createSocialLink(RequestInterface $request): void
    {
        $data = $request->post('social');
        
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
