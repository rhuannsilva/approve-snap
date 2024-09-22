<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestUploadResource;
use App\Interfaces\RequestUploadRepositoryInterface;
use App\Interfaces\FilesRepositoryInterface;
use App\Models\RequestsUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller{ 

    private FilesRepositoryInterface $filesRepositoryInterface;

    public function __construct(FilesRepositoryInterface $filesRepositoryInterface){

        $this->filesRepositoryInterface = $filesRepositoryInterface;
    }

    public function store($data){

        $this->filesRepositoryInterface->store($data);
    }

    public function update($id, $data){
        
        $this->filesRepositoryInterface->update($id, $data);
    }
}