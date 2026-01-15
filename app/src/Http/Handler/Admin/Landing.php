<?php

namespace App\Http\Handler\Admin;

use App\Http\Handler\AdminController;
use App\Model\LandingPageContent;

class Landing extends AdminController
{
    protected function handleRequest(): void
    {
        $sections = LandingPageContent::getAllSections();
        $sectionsConfig = LandingPageContent::getSectionsConfig();

        $this->render(
            'admin/landing',
            [
                'sections' => $sections,
                'sectionsConfig' => $sectionsConfig,
            ]
        );
    }
}
