<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestUploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id_request,
            'id_requesting_user' => $this->id_requesting_user,
            'status' => $this->status,
            'observation' => $this->observation,
            'created_at' => $this->created_at,
        ];
    }
}
