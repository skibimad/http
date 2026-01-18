<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\SocialLink;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Social extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        $collection = $this->getSocialLinks();
        
        // Handle pagination
        $page = max(1, (int)$request('page', 1));
        $pageSize = (int)$request('pageSize', 10);
        
        if ($pageSize < 1) {
            $pageSize = 10;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        return $this->layout(
            'skibidi/admin',
            'social',
            [
                'socialLinks' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    protected function getSocialLinks()
    {
        $socialLinksCollection = (new SocialLink())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('display_order', 'ASC');

        return $socialLinksCollection;
    }
}
