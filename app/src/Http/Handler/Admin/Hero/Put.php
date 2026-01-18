<?php

namespace App\Http\Handler\Admin\Hero;

use App\Http\Handler\Admin\AdminHandler;
use Juzdy\Config;
use App\Model\Hero;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Put extends AdminHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isPost()) {
            $this->createHero($request);
        }

        return $this->redirect('/admin/heroes');
    }

    /**
     * Create a new hero based on request data
     * @param RequestInterface $request
     * @return void
     */
    protected function createHero(RequestInterface $request): void
    {
        $heroData = $request->post('hero');
        $this->assertValid($heroData);
        unset($heroData['id']);
        $hero = new Hero();
        $hero->create($heroData);

        // Upload image if provided
        $imagePath = $this->uploadFile($hero, 'hero_image', $request);
        if ($imagePath) {
            $hero->set('image', $imagePath)->save();
        }

        // Upload video if provided
        $videoPath = $this->uploadFile($hero, 'hero_video', $request);
        if ($videoPath) {
            $hero->set('video', $videoPath)->save();
        }
    }

    /**
     * Validate the hero data
     *
     * @param array $data
     * @return bool
     */
    protected function assertValid(array &$data): bool
    {
        return true;
    }

    protected function uploadFile(Hero $hero, string $fieldName, RequestInterface $request): string
    {
        $uploader = new Uploader($request);
        $uploadPath = Config::get('path.uploads') . '/hero/' . $hero->getId() . '/';

        $uploads = $uploader->upload($fieldName, $uploadPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return '/uploads/hero/' . $hero->getId() . '/' . $uploads[0];
    }
}
