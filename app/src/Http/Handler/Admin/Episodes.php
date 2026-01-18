<?php

namespace App\Http\Handler\Admin;


use App\Http\Handler\Admin\AdminHandler;
use Juzdy\Model\CollectionInterface;
use App\Model\Episode;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Episodes extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        $collection = $this->getEpisodes();
        
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
            'episodes',
            [
                'episodes' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    /**
     * Retrieve episodes collection
     *
     * @return CollectionInterface
     */
    protected function getEpisodes()
    {
        $episodeCollection = (new Episode())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC');

        return $episodeCollection;
    }
}
