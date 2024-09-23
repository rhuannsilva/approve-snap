<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;

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
            'id_request' => $this->id_request,
            'id_requesting_user' => $this->id_requesting_user,
            'id_analysis_user' => $this->id_analysis_user,
            'status' => $this->status,
            'observation' => $this->observation,
            'description' => $this->description,
            'create_date' => $this->create_date,
            'edit_date' => $this->edit_date,
            'requesting_user' => $this->requestingUser ? [
                'id' => $this->requestingUser->id,
                'name' => $this->requestingUser->name,
            ] : null,
            'analysis_user' => $this->analysisUser ? [
                'id' => $this->analysisUser->id,
                'name' => $this->analysisUser->name,
            ] : null,
            'files' => ImageResource::collection($this->files)
        ];
    }
}
