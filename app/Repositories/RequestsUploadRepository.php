<?php

namespace App\Repositories;
use App\Interfaces\RequestsUploadRepositoryInterface;
use App\Models\RequestsUploads;

class RequestsUploadRepository implements RequestsUploadRepositoryInterface{
    public function index(){

        return RequestsUploads::with([
            'requestingUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            },
            'analysisUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            }])
        ->get();
    }
    public function getById($id){
       return RequestsUploads::findOrFail($id);
    }
    public function store(array $data){
       return RequestsUploads::create($data);
    }
    public function update(array $data,$id){
       return RequestsUploads::whereId($id)->update($data);
    }
    public function delete($id){
        RequestsUploads::destroy($id);
    }
}
