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
|Route::controller(RecttesController::class)->group(function(){
    Route::get('recettes-by-day/{date}','getRecttesByDay');
    Route::get('recettes-by-month/{month}','getByMonth');
    Route::get('recettes-minerval-by-month/{month}','getMinervalByMonth');
    Route::get('recettes-minerval-by-day/{day}','getMinervalByDay');
    Route::get('recettes-all/{month}','getAllRecettes');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
});
Route::controller(RecttesController::class)->group(function(){
    Route::get('recettes-all/{month}','getAllRecettes');
});
Route::middleware(['auth:sanctum'])->group(function(){


    Route::controller(AuthController::class)->group(function(){
        Route::get('user','user');
    });
});

