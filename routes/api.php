<?php

use App\Http\Controllers\RequestsUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [RequestsUploadController::class,'index']);
Route::post('/create', [RequestsUploadController::class,'store']);
Route::post('/approve-or-rejected', [RequestsUploadController::class,'approveOrRejected']);
