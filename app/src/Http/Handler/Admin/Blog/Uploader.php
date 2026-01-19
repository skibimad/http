<?php
namespace App\Http\Handler\Admin\Blog;

use Juzdy\Http\RequestInterface;
use Juzdy\Request;

class Uploader
{
    

    /**
     * Constructor
     *
     * @param RequestInterface $request
     */
    public function __construct(
        private RequestInterface $request
    )
    {}

    /**
     * Get the current request instance
     *
     * @return RequestInterface
     */
    protected function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Upload files from the request
     *
     * @param string $key
     * @param string $to
     * @return array
     */
    public function upload(string $key, string $to): array
    {
        $uploaded = [];

        foreach ($this->getRequest()->files($key) as $file) {
            $uploaded[] = $this->uploadFile($file, $to);
        }
        
        return $uploaded;
        
    }

    /**
     * Upload a single file
     *
     * @param array $fileData
     * @param string $to
     * @return string|false
     */
    public function uploadFile(array $fileData, string $to): string|false
    {
        $tmp_name = $fileData['tmp_name'];
        $fileext = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $filename = uniqid('blog_', true) . '.' . $fileext;
        $filePath = $to . $filename;

        if (!is_dir($to)) {
            @mkdir($to, 0755, true);
        }

        $success = move_uploaded_file(
            $tmp_name,
            $filePath
        );

        return $success ? $filename : false;
    }


}