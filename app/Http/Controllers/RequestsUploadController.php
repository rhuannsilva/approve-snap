<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestUploadResource;
use App\Interfaces\RequestUploadRepositoryInterface;
use App\Interfaces\FilesRepositoryInterface;
use App\Models\RequestsUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FilesController;
use App\Services\FileStorageService;
use App\Utils\Logger;

class RequestsUploadController extends Controller{

    private RequestUploadRepositoryInterface $requestUploadRepositoryInterface;
    private FilesRepositoryInterface $filesRepository;

    public function __construct(
        RequestUploadRepositoryInterface $requestUploadRepositoryInterface,
    ){

        $this->requestUploadRepositoryInterface = $requestUploadRepositoryInterface;
    }
    public function index(Request $request){

        try {
            
            return response()->json([
                'data' => $this->requestUploadRepositoryInterface->index()
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    public function store (Request $request){

        try {

            $data = $request->all();

            $upload = [
                'id_requesting_user' => $data['user'],
                'status' => 0,
            ];

            $resultUpload = $this->requestUploadRepositoryInterface->store($upload);

            foreach ($data['images'] as $key => $value) {

                $data['images'][$key]['name'] = str_replace(' ', '-', $value['name']);
            }

            $fileController = app()->make(FilesController::class);

            foreach($data['images'] as $item){

                $result = FileStorageService::upload($item);

                if($result){

                    $file = [
                        'id_request' => $resultUpload->id_request,
                        'name_file' => $item['name'],
                        'path' => '/pending/' . $item['name'],
                    ];

                    $fileController->store($file);

                }

            }

            return response()->json([
                'msg' => 'Imagens criadas com sucesso'
            ], 200);


        } catch (\Throwable $th) {

            Logger::error('[RequestUploadController]', '[store]',$th->getMessage());

            return response()->json([
                'msg' => $th->getMessage(),
            ], 500);
        }

    }
}
