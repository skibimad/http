<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\Admin\AdminHandler;

use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Model\SocialLink;

class Update extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isPost()) {
            $this->updateSocialLink($request);
            return $this->redirect('/admin/social');
        }

        return $this->layout(
            'skibidi/admin/',
            'social/form',
            [
                'socialLink' => $this->findSocialLink($request)
            ]
        );
    }

    /**
     * Find a social link by ID from the request
     *
     * @param RequestInterface $request
     * @return SocialLink
     */
    protected function findSocialLink(RequestInterface $request): SocialLink
    {
        $socialLink = new SocialLink();
        $socialLink->load($request->query('id'));

        return $socialLink;
    }

    /**
     * Update an existing social link from request data
     *
     * @param RequestInterface $request
     * @return void
     */
    protected function updateSocialLink(RequestInterface $request): void
    {
        $data = $request->post('social');
        
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
