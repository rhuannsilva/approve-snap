<?php

namespace App\Repositories;
use App\Interfaces\RequestUploadRepositoryInterface;
use App\Models\RequestUploads;

class RequestUploadRepository implements RequestUploadRepositoryInterface{
    public function index($filter){

        $page = $filter['page'] ?? 1;
        $status = $filter['status'] ?? 0;

        return RequestUploads::with([

            'requestingUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            },
            'analysisUser' => function ($query) { 
                $query->select('id', 'name', 'permission');
            },
            'files'])

        ->where(function ($query) use ($status) {
            if($status != 3){
                $query->where('status', $status);
            }
        })
        ->orderBy('id_request', 'desc')
        ->paginate(10, ['*'], 'page', $page);
    }
    public function getById($id){
       return RequestUploads::where('id_request',$id)->with('files')->get()->first();
    }
    public function store(array $data){
       return RequestUploads::create($data);
    }
    public function update(array $data,$id){
       return RequestUploads::where('id_request', $id)->update($data);
    }
    public function delete($id){
        RequestUploads::destroy($id);
    }
}
