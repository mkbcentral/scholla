<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecttesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(RecttesController::class)->group(function(){
    Route::get('recettes-by-day/{date}','getRecttesByDay');
    Route::get('recettes-by-month/{month}','getByMonth');
    Route::get('recettes-minerval-by-month/{month}','getMinervalByMonth');
    Route::get('recettes-minerval-by-day/{day}','getMinervalByDay');
    Route::get('recettes-all/{month}','getAllRecettes');
});
*/



Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::controller(RecttesController::class)->group(function(){
        Route::get('recettes-frais-by-month/{month}','getRecetteFraisByMonth');
        Route::get('recettes-inscription-by-month/{month}','getRecetteInscriptionByMonth');
    });
    Route::controller(AuthController::class)->group(function(){
        Route::get('user','user');
    });
});

