<?php

namespace App\Http\Handler\Admin;


use App\Http\Handler\Admin\AdminHandler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use Juzdy\Model\CollectionInterface;

class Blog extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        $collection = $this->getPosts();
        
        // Handle pagination
        $page = max(1, (int)$request('page') ?? 1);
        $pageSize = (int)$request('pageSize') ?? 6;
        
        if ($pageSize < 1) {
            $pageSize = 6;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        return $this->layout(
            'skibidi/admin',
            'blog',
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
