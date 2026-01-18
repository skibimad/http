<?php

namespace App\Http\Handler\Admin;

use App\Model\LandingPageContent;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Landing extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        $sections = LandingPageContent::getAllSections();
        $sectionsConfig = LandingPageContent::getSectionsConfig();

        return $this->layout(
            'skibidi/admin',
            'landing',
            [
                'sections' => $sections,
                'sectionsConfig' => $sectionsConfig,
            ]
        );
    }
}
