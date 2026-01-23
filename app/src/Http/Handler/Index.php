<?php
namespace App\Http\Handler;

use Juzdy\Http\Handler;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use Juzdy\Model\Collection;
use Juzdy\Container\Attribute\Parameter\Using;
use Juzdy\Contract\ModelInterface;
use Juzdy\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\LandingPageContent;
use App\Model\SocialLink;

class Index extends Handler
{

    public function __construct(
        #[Using(SocialLink::class)]
        private ModelInterface $socialLinkModel,
        #[Using(BlogPost::class)]
        private ModelInterface $blogPostModel,
        #[Using(\App\Model\Episode::class)]
        private ModelInterface $episodeModel,
        #[Using(\App\Model\Hero::class)]
        private ModelInterface $heroModel,

    )
    {}

    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->layout(
            'skibidi',
            'landing',
            [
                'getLandingContent' => $this->getLandingContent(),
                'episodes' => $this->getEpisodes(),
                'blogPosts' => $this->getBlogPosts(),
                'heroes' => $this->getHeroes(),
                'socialLinks' => $this->getSocialLinks(),
            ],
        );
    }

    /**
     * Retrieve landing page content from database
     * And wrap it in a callable for easy access in views
     *
     * @return callable
     */
    protected function getLandingContent(): callable
    {
         $landingContent = LandingPageContent::getAllSections();

         $getContent = function($section, $key) use ($landingContent) {
            return isset($landingContent[$section][$key]) ? $landingContent[$section][$key]['value'] : '';
        };
        return $getContent;
    }

    /**
     * Retrieve social links collection
     *
     * @return Collection
     */
    protected function getSocialLinks(): CollectionInterface
    {
        return $this->socialLinkModel
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->addFilter(['enabled' => 1])
            ->sort('display_order', 'ASC');
    }

    /**
     * Retrieve heroes collection
     *
     * @return Collection
     */
    protected function getHeroes(): CollectionInterface
    {
        return $this->heroModel
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->sort('name', 'ASC');
    }

    /**
     * Retrieve blog posts collection
     *
     * @return Collection
     */
    protected function getBlogPosts(): CollectionInterface
    {
        return $this->blogPostModel
            ->getCollection()
            ->addFilter(['published' => 1])
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC')
            ->setPageSize(5);
    }

    /**
     * Retrieve episodes collection
     *
     * @return Collection
     */
    protected function getEpisodes(): CollectionInterface
    {
        return $this->episodeModel
            ->getCollection()
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            ->addFilter(['status' => 1])
            ->sort('created_at', 'DESC');
    }

}