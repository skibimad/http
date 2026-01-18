<?php

namespace App\Http\Handler\Admin\Social;

use App\Http\Handler\Admin\AdminHandler;
use App\Model\SocialLink;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Delete extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $id = $request->query('id');
        
        if ($id) {
            $socialLink = new SocialLink();
            $socialLink->delete((int)$id);
        }
        
        return $this->redirect('/admin/social');
    }
}
