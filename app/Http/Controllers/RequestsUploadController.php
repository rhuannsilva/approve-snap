<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestUploadResource;
use App\Interfaces\RequestsUploadRepositoryInterface;
use App\Models\RequestsUploads;
use Illuminate\Http\Request;

class RequestsUploadController extends Controller{

    private RequestsUploadRepositoryInterface $requestsUploadRepositoryInterface;

    public function __construct(RequestsUploadRepositoryInterface $requestsUploadRepositoryInterface){

        $this->requestsUploadRepositoryInterface = $requestsUploadRepositoryInterface;

    }
    public function index(Request $request){

        try {
            
            return response()->json([
                'data' => $this->requestsUploadRepositoryInterface->index()
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'msg' => $th->getMessage(),
            ], 500);
        }
    }
}
