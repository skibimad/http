<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use App\Model\LandingPageContent;

class Landing extends AdminController
{
    public function handle(): void
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
