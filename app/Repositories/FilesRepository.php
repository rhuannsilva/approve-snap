<?php

namespace App\Repositories;
use App\Interfaces\FilesRepositoryInterface;
use App\Models\Files;

class FilesRepository implements FilesRepositoryInterface {

    public function store($data){
        return Files::create($data);
    }
}