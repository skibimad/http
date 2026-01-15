<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;

class Blog extends AdminController
{
    protected function handleRequest(): void
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

        $this->renderView(
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
