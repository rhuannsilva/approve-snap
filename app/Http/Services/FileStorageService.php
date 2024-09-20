<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Utils\Logger;

class FileStorageService{
    public static function upload(Array $data) : bool{
        
        try {

            Storage::put('/pending/' . $data['name'], file_get_contents($data['url']));

            return true;

        } catch (\Throwable $th) {
            
            Logger::error('[FileStorageService]', '[storeFile]', $th->getMessage());

            return false;
        }
    }
}