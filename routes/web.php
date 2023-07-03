<?php

use App\Http\Controllers\Application\Pages\ApplicationDashboardController;
use App\Http\Controllers\Application\Pages\ApplicationLinkController;
use App\Http\Livewire\Application\Dashboard\MainDashboard;
use App\Http\Livewire\Application\Inscription\NewInscription;
use App\Http\Livewire\Application\Navigation\ApplicationLinkMenuSub;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
Route::middleware('auth')->group(function () {
    Route::get('/', ApplicationLinkController::class)->name('main');
    //INSCRIPTION REFACTORING
    Route::prefix('inscription')->group(function () {
        Route::get('app-x-link/{appLink?}', MainDashboard::class)->name('dashboard');
        Route::get('new-inscription',NewInscription::class)->name('inscription.new');
    });

});
