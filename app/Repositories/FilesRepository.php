<?php

namespace App\Repositories;
use App\Interfaces\FilesRepositoryInterface;
use App\Models\Files;

class FilesRepository implements FilesRepositoryInterface {

    public function store($data){
        return Files::create($data);
    }

    public function update($id,$data){
        return Files::where("id",$id)->update($data);
    }
}