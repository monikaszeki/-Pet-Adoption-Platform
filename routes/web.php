<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Pet routes
 */
Route::get('/pets', [App\Http\Controllers\PetController::class, 'index'])->name('pets');
Route::get('/pets/getPetList', [App\Http\Controllers\PetController::class, 'getPetList'])->name('getPetList');
Route::get('/pets/createPetList', [App\Http\Controllers\PetController::class, 'updatePetList'])->name('createPetList');
Route::get('/pets/updatePetList/{petId}', [App\Http\Controllers\PetController::class, 'updatePetList'])->name('updatePetList');

Route::post('/pets', [App\Http\Controllers\PetController::class, 'store'])->name('store');
Route::patch('/pets/{id}', [App\Http\Controllers\PetController::class, 'update'])->name('update');
Route::get('/pets/{petId}', [App\Http\Controllers\PetController::class, 'deletePetList'])->name('delete');

