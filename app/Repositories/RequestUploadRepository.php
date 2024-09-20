<?php

namespace App\Repositories;
use App\Interfaces\RequestUploadRepositoryInterface;
use App\Models\RequestUploads;

class RequestUploadRepository implements RequestUploadRepositoryInterface{
    public function index(){

        return RequestUploads::with([
            'requestingUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            },
            'analysisUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            },
            'files'])
        ->get();
    }
    public function getById($id){
       return RequestUploads::findOrFail($id);
    }
    public function store(array $data){
       return RequestUploads::create($data);
    }
    public function update(array $data,$id){
       return RequestUploads::whereId($id)->update($data);
    }
    public function delete($id){
        RequestUploads::destroy($id);
    }
}
