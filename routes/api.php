<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Gestion de connexion et déconnexion
Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'login'])->name('login');
Route::post('deconnexion',[\App\Http\Controllers\Api\AuthController::class,'deconnexion'])->name('deconnexion');

//Gestion des clients
Route::post('add_user',[\App\Http\Controllers\Api\AuthController::class,'add_user'])->name('add_user');
Route::post('update_client/{id}',[\App\Http\Controllers\Api\AuthController::class,'update_client'])->name('update_client');

//Gestion des reservations
Route::get('mes_reservation}',[\App\Http\Controllers\Api\AuthController::class,'mes_reservation'])->name('mes_reservation');
Route::post('add_reservation}',[\App\Http\Controllers\Api\AuthController::class,'add_reservation'])->name('add_reservation');
Route::get('verifier_reservation/{id}',[\App\Http\Controllers\Api\AuthController::class,'verifier_reservation'])->name('verifier_reservation');
Route::post('update_reservation/{id}',[\App\Http\Controllers\Api\AuthController::class,'update_reservation'])->name('update_reservation');
Route::get('delete_reservation/{id}',[\App\Http\Controllers\Api\AuthController::class,'delete_reservation'])->name('delete_reservation');
Route::post('achat_place',[\App\Http\Controllers\Api\AuthController::class,'achat_place'])->name('achat_place');
Route::get('annuler_place/{id}',[\App\Http\Controllers\Api\AuthController::class,'annuler_place'])->name('annuler_place');
Route::post('filter',[\App\Http\Controllers\Api\AuthController::class,'filter'])->name('filter');


