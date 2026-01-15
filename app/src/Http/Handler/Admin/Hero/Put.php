<?php

namespace App\Http\Handler\Admin\Hero;

use App\Http\Handler\AdminController;
use Juzdy\Config;
use App\Model\Hero;

class Put extends AdminController
{
    protected function handleRequest(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->createHero();
        }

        $this->redirectTo('/admin/heroes');
    }

    protected function createHero()
    {
        $heroData = $this->getRequest()->post('hero');
        $this->assertValid($heroData);
        unset($heroData['id']);
        $hero = new Hero();
        $hero->create($heroData);

        // Upload image if provided
        $imagePath = $this->uploadFile($hero, 'hero_image');
        if ($imagePath) {
            $hero->set('image', $imagePath)->save();
        }

        // Upload video if provided
        $videoPath = $this->uploadFile($hero, 'hero_video');
        if ($videoPath) {
            $hero->set('video', $videoPath)->save();
        }
    }

    protected function assertValid(array &$data)
    {
        return true;
    }

    protected function uploadFile(Hero $hero, string $fieldName): string
    {
        $uploader = new Uploader($this->getRequest());
        $uploadPath = Config::get('upload_dir') . 'hero/' . $hero->getId() . '/';

        $fullPath = Config::get('root') . 'public' . $uploadPath;

        $uploads = $uploader->upload($fieldName, $fullPath);

        if (!isset($uploads[0]) || !$uploads[0]) {
            return '';
        }

        return $uploadPath . $uploads[0];
    }
}
