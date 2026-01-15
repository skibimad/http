<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\Hero;

class Heroes extends AdminController
{
    protected function handleRequest(): void
    {
        $collection = $this->getHeroes();
        
        // Handle pagination
        $page = max(1, (int)$this->getRequest('page', 1));
        $pageSize = (int)$this->getRequest('pageSize', 6);
        
        if ($pageSize < 1) {
            $pageSize = 6;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        $this->render(
            'admin/heroes',
            [
                'heroes' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    protected function getHeroes()
    {
        $heroCollection = (new Hero())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('id', 'DESC');

        return $heroCollection;
    }
}
