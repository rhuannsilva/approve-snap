<?php

namespace App\Http\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_request' => $this->id_request,
            'name_file' => $this->name_file,
            'path' => $this->path,
            'base64' => FileStorageService::getImage($this->path), 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
