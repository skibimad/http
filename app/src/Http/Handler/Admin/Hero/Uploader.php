<?php
namespace App\Http\Handler\Admin\Hero;

use Juzdy\Http\RequestInterface;

class Uploader
{
    

    public function __construct(
        private RequestInterface $request
    )
    {}

    protected function getRequest()
    {
        return $this->request;
    }

    public function upload(string $key, string $to): array
    {
        $uploaded = [];

        foreach ($this->getRequest()->files($key) as $file) {
            // Skip if no file was uploaded or if there's an upload error
            if (empty($file['tmp_name']) || !empty($file['error'])) {
                continue;
            }
            
            $uploaded[] = $this->uploadFile($file, $to);
        }
        
        return $uploaded;
        
    }

    public function uploadFile(array $fileData, string $to): string|false
    {
        $tmp_name = $fileData['tmp_name'];
        $fileext = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $filename = uniqid('hero_', true) . '.' . $fileext;
        $filePath = $to . $filename;

        if (!is_dir($to)) {
           
            mkdir($to, 0755, true);
        }

        $success = move_uploaded_file(
            $tmp_name,
            $filePath
        );

        return $success ? $filename : false;
    }


}
