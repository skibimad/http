<?php

namespace App\Http\Handler\Admin\Landing;

use App\Http\Handler\AdminController;
use Juzdy\Config;
use App\Model\LandingPageContent;

class Update extends AdminController
{
    protected function handleRequest(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->updateContent();
            $this->redirect('/admin/landing');
        }

        // Redirect to landing page if accessed via GET
        $this->redirect('/admin/landing');
    }

    protected function updateContent(): void
    {
        $landingData = $this->getRequest()->post('landing');
        
        if (!is_array($landingData)) {
            return;
        }

        $sectionsConfig = LandingPageContent::getSectionsConfig();

        foreach ($landingData as $section => $fields) {
            if (!isset($sectionsConfig[$section])) {
                continue;
            }

            foreach ($fields as $fieldKey => $value) {
                if (!isset($sectionsConfig[$section]['fields'][$fieldKey])) {
                    continue;
                }

                $fieldType = $sectionsConfig[$section]['fields'][$fieldKey]['type'];
                
                // Handle image uploads
                if ($fieldType === LandingPageContent::FIELD_TYPE_IMAGE) {
                    $uploadedImage = $this->handleImageUpload($section, $fieldKey);
                    if ($uploadedImage) {
                        $value = $uploadedImage;
                    }
                }
                
                LandingPageContent::setValue($section, $fieldKey, $value, $fieldType);
            }
        }
    }
    
    protected function handleImageUpload(string $section, string $fieldKey): ?string
    {
        $fileKey = "landing_image_{$section}_{$fieldKey}";
        $files = $this->getRequest()->files($fileKey);
        
        if (empty($files) || empty($files[0]['tmp_name'])) {
            return null;
        }
        
        $file = $files[0];
        
        // Validate file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return null;
        }
        
        // Generate upload path
        $uploadDir = Config::get('upload_dir') . 'landing/';
        $fullPath = Config::get('root') . 'public' . $uploadDir;
        
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid("{$section}_{$fieldKey}_", true) . '.' . $extension;
        $filePath = $fullPath . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $uploadDir . $filename;
        }
        
        return null;
    }
}
