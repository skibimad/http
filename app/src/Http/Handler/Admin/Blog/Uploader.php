<?php
namespace App\Http\Handler\Admin\Blog;

use Juzdy\Http\Request;

class Uploader
{
    

    public function __construct(
        private Request $request
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
            $uploaded[] = $this->uploadFile($file, $to);
        }
        
        return $uploaded;
        
    }

    public function uploadFile(array $fileData, string $to): string|false
    {
        $tmp_name = $fileData['tmp_name'];
        $fileext = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $filename = uniqid('blog_', true) . '.' . $fileext;
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