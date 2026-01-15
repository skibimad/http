<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\SocialLink;

class Social extends AdminController
{
    public function handle(): void
    {
        $collection = $this->getSocialLinks();
        
        // Handle pagination
        $page = max(1, (int)$this->getRequest('page', 1));
        $pageSize = (int)$this->getRequest('pageSize', 10);
        
        if ($pageSize < 1) {
            $pageSize = 10;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        $this->render(
            'admin/social',
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
