<?php
namespace App\Http\Handler\Admin\Episode;

use Juzdy\Http\RequestInterface;

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
     * Get the current request
     *
     * @return RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Upload multiple files
     *
     * @param string $key
     * @param string $to
     * @return array
     */
    public function upload(string $key, string $to): array
    {
        $uploaded = [];
        
        // Get files from request
        $files = $this->getRequest()->files($key);
        
        // Handle empty case
        if (empty($files)) {
            return $uploaded;
        }
        
        // Iterate through files
        foreach ($files as $file) {
            // Skip if file is not an array or doesn't have required fields
            if (!is_array($file) || !isset($file['tmp_name'])) {
                continue;
            }
            
            // Skip if no file was uploaded or if there's an upload error
            if (empty($file['tmp_name']) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
                continue;
            }
            
            // Validate the upload
            if (!is_uploaded_file($file['tmp_name'])) {
                continue;
            }
            
            $result = $this->uploadFile($file, $to);
            if ($result) {
                $uploaded[] = $result;
            }
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
        // Validate required fields
        if (!isset($fileData['tmp_name'], $fileData['name'])) {
            return false;
        }
        
        $tmp_name = $fileData['tmp_name'];
        $fileext = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $filename = uniqid('episode_', true) . '.' . $fileext;
        $filePath = $to . $filename;

        // Create directory if it doesn't exist
        if (!is_dir($to)) {
            @mkdir($to, 0755, true);
            if (!is_dir($to)) {
                return false;
            }
        }

        // Move uploaded file
        $success = move_uploaded_file($tmp_name, $filePath);

        return $success ? $filename : false;
    }


}