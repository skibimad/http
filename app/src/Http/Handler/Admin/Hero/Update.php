<?php

namespace App\Http\Handler\Admin\Hero;

use App\Helper\Uploader;
use Juzdy\Config;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;
use App\Http\Handler\Admin\AdminHandler;
use App\Model\Hero;

class Update extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isPost()) {
            $this->updateHero($request);
            return $this->redirect('/admin/heroes');
        }

        return $this->layout(
            'skibidi/admin/',
            'hero/form',
            [
                'hero' => $this->findHero($request)
            ]
        );
    }

    protected function findHero(RequestInterface $request): Hero
    {
        $hero = new Hero();
        $hero->load($request->query('id'));

        return $hero;
    }

    protected function updateHero(RequestInterface $request): void
    {
        $heroData = $request->post('hero');
        $this->assertValid($heroData);
        $hero = new Hero();
        $hero->load($heroData['id']);
        unset($heroData['id']);
        $hero->setData($heroData)->save();

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

    protected function assertValid(array &$data)
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

        return '/pub/uploads/hero/' . $hero->getId() . '/' . $uploads[0];
    }
}
