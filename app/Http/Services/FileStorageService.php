<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Utils\Logger;

class FileStorageService{
    public static function upload(Array $data, $id_request) : bool{
        
        try {

            $file_name = $id_request . '-' . $data['name'];

            Storage::put('/pending/' . $file_name, file_get_contents($data['url']));

            return true;

        } catch (\Throwable $th) {
            
            Logger::error('[FileStorageService]', '[storeFile]', $th->getMessage());

            return false;
        }
    }

    public static function getImage(String $path){

        if(Storage::exists($path)){

            $file_content = Storage::get($path);
            $mime_type = Storage::mimeType($path);
            $base64_image = base64_encode($file_content);

            return "data:{$mime_type};base64,{$base64_image}";
        }
    }

    public static function moveImage($data, $status_request) : string{

        $status = [
            1 => "/approved/",
            2 => "/rejected/"
        ];

        if(Storage::exists($data['path'])){
            Storage::move($data['path'], $status[$status_request] . $data['name_file']);
        }

        return $status[$status_request] . $data['name_file'];

    }
}