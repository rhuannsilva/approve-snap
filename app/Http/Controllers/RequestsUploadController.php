<?php

namespace App\Http\Controllers;

use App\Interfaces\RequestUploadRepositoryInterface;
use App\Interfaces\FilesRepositoryInterface;
use App\Models\RequestsUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FilesController;
use App\Http\Services\FileStorageService;
use App\Http\Resources\RequestUploadResource;
use App\Utils\Logger;
use PhpParser\Node\Expr\Cast\Object_;

class RequestsUploadController extends Controller{

    private RequestUploadRepositoryInterface $requestUploadRepositoryInterface;

    public function __construct(
        RequestUploadRepositoryInterface $requestUploadRepositoryInterface,
    ){

        $this->requestUploadRepositoryInterface = $requestUploadRepositoryInterface;
    }
    public function index(Request $request){

        try {

            $request_upload = $this->requestUploadRepositoryInterface->index($request->query());
            $meta = $request_upload->toArray();
            unset($meta['data']);

            return response()->json([
                'data' => RequestUploadResource::collection($request_upload),
                'meta' => [
                    $meta
                ]
            ], 200);

        } catch (\Throwable $th) {

            Logger::error('[RequestUploadController]', '[index]',$th->getMessage());

            return response()->json([
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    public function update($data, $id){

        $this->requestUploadRepositoryInterface->update($data, $id);
    }

    public function store (Request $request) : Object {

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

                $result = FileStorageService::upload($item, $resultUpload->id_request);

                if($result){

                    $file = [
                        'id_request' => $resultUpload->id_request,
                        'name_file' => $resultUpload->id_request . '-' . $item['name'],
                        'path' => '/pending/' . $resultUpload->id_request . '-' . $item['name'],
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
                'msg' => $th->getLine() . $th->getMessage(),
            ], 500);
        }

    }

    public function approveOrRejected(Request $request) : Object {

        $id_request = @$request->id_request;
        $status = @$request->status;
        $id_user_analysis = @$request->id_user_analysis;
        $observation = @$request->observation;

        $request_analysis = $this->requestUploadRepositoryInterface->getById($id_request);

        $file_controller = app()->make(FilesController::class);

        foreach($request_analysis->files as $item){

            $new_path = FileStorageService::moveImage($item, $status);

            $update_file = [
                'path' => $new_path
            ];

            $file_controller->update($item->id, $update_file);
        }

        $update_request_upload = [
            'status' => $status,
            'id_analysis_user' => $id_user_analysis,
            'observation' => $observation
        ];

        $this->update($update_request_upload, $id_request);

        return response()->json([
            'msg' => 'Analisado com sucesso'
        ], 200);
    }
}
