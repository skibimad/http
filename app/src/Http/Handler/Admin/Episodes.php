<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use Juzdy\Model\CollectionInterface;
use App\Model\Episode;

class Episodes extends AdminController
{
    public function handle(): void
    {
        $collection = $this->getEpisodes();
        
        // Handle pagination
        $page = max(1, (int)$this->getRequest('page', 1));
        $pageSize = (int)$this->getRequest('pageSize', 6);
        
        if ($pageSize < 1) {
            $pageSize = 6;
        }
        
        $collection->setPageSize($pageSize);
        $collection->setPage($page);

        $this->render(
            'admin/episodes',
            [
                'episodes' => $collection,
                'currentPage' => $collection->getPage(),
                'totalPages' => $collection->getPages(),
                'pageSize' => $pageSize,
                'totalCount' => $collection->count()
            ]
        );
    }

    protected function getEpisodes()
    {
        $episodeCollection = (new Episode())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC');

        return $episodeCollection;
    }
}
