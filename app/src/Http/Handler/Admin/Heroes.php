<?php

namespace App\Http\Handler\Admin;


use Juzdy\Model\CollectionInterface;
use App\Model\Hero;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Heroes extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $collection = $this->getHeroes();
        
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
            'heroes',
            [
                'heroes' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    /**
     * Retrieve heroes collection
     *
     * @return CollectionInterface
     */
    protected function getHeroes()
    {
        $heroCollection = (new Hero())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('id', 'DESC');

        return $heroCollection;
    }
}
