<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;

class Blog extends AdminController
{
    public function handle(): void
    {
        $collection = $this->getPosts();
        
        // Handle pagination
        $page = max(1, (int)$this->request('page') ?? 1);
        $pageSize = (int)$this->request('pageSize') ?? 6;
        
        if ($pageSize < 1) {
            $pageSize = 6;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        $this->render(
            'admin/blog',
            [
                'posts' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    protected function getPosts()
    {
        $blogPostsCollection = (new \App\Model\BlogPost())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC');

        return $blogPostsCollection;
    }
}
