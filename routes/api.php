<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Paiment\ApiPaimentRapportController;
use App\Http\Controllers\Api\Paiment\ApiTotalPaiment;
use App\Http\Controllers\Api\Paiment\ApiTotalPaimentController;
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
Route::middleware('auth:sanctum')->group(function(){
    Route::controller(ApiPaimentRapportController::class)->group(function(){
        //By cost routes
        Route::get('paiment/month/{month}','getPaiemntGetMonthPaiments');
        Route::get('paiment/date/{date}','getPaiemntGetDate');
        Route::get('paiment/all/{scolaryYear}','getPaiemntAll');
        //By section routes
        Route::get('paiment/month/section/{month}','getPaiemntGetMonthSectionPaiments');
        Route::get('paiment/date/section/{date}','getPaiemntGetDateSectionPaiments');
        Route::get('paiment/all/section/{idSColaryYear}','getPaiemntGetAllSectionPaiments');

        //GET TOTAL
        Route::get('total/paiment/date/{date}','getPaiemntGetDate');
    });

    Route::controller(ApiTotalPaimentController::class)->group(function(){
        //GET TOTAL
        Route::get('total/paiment/date/{date}','getTotalBByDay');
    });
});


Route::controller(RecttesController::class)->group(function(){
    Route::get('recettes-by-day/{date}','getRecttesByDay');
    Route::get('recettes-by-month/{month}','getByMonth');
    Route::get('recettes-minerval-by-month/{month}','getMinervalByMonth');
    Route::get('recettes-minerval-by-day/{day}','getMinervalByDay');
    Route::get('recettes-all/{month}','getAllRecettes');
});

