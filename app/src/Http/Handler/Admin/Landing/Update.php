<?php

namespace App\Http\Handler\Admin\Landing;

use App\Http\Handler\Admin\AdminHandler;
use Juzdy\Config;
use App\Model\LandingPageContent;
use Juzdy\Http\RequestInterface;
use Juzdy\Http\ResponseInterface;

class Update extends AdminHandler
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($request->isPost()) {
            $this->updateContent($request);
        }

        // Redirect to landing page if accessed via GET
        return $this->redirect('/admin/landing');
    }

    /**
     * Update landing page content based on request data
     */
    protected function updateContent(RequestInterface $request): void
    {
        $landingData = $request->post('landing');
        
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
                    $uploadedImage = $this->handleImageUpload($section, $fieldKey, $request);
                    if ($uploadedImage) {
                        $value = $uploadedImage;
                    }
                }
                
                LandingPageContent::setValue($section, $fieldKey, $value, $fieldType);
            }
        }
    }
    
    /**
     * Handle image upload for landing page sections
     *
     * @param string $section
     * @param string $fieldKey
     * @param RequestInterface $request
     * @return string|null
     */
    protected function handleImageUpload(string $section, string $fieldKey, RequestInterface $request): ?string
    {
        $fileKey = "landing_image_{$section}_{$fieldKey}";
        $files = $request->files($fileKey);
        
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
        $uploadPath = Config::get('path.uploads') . '/landing/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid("{$section}_{$fieldKey}_", true) . '.' . $extension;
        $filePath = $uploadPath . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return '/uploads/landing/' . $filename;
        }
        
        return null;
    }
}
