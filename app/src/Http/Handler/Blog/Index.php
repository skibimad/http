<?php
namespace App\Http\Handler\Blog;

use Juzdy\Model\Collection;
use App\Model\BlogPost;
use Juzdy\Http\Handler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Index extends Handler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi',
            'blog/index', 
            [
                'blogPosts' => $this->getBlogPosts(),
            ],
    );
        
    }

    /**
     * Retrieve blog posts collection
     *
     * @return Collection
     */
    protected function getBlogPosts(): Collection
    {
        $blogPostsCollection = (new BlogPost())
            ->getCollection()
            ->addFilter(['published' => 1])
            ->sort('created_at', 'DESC')
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            //->setPageSize(5)
            ;

        return $blogPostsCollection;
    }


}