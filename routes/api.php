<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('pets', PetApiController::class);
Route::resource('store', PetApiController::class);
Route::resource('update', PetApiController::class);
Route::resource('destroy', PetApiController::class);

