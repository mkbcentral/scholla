<?php

use App\Http\Controllers\DepenseController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MouvementBankController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PaimentPrinterConteroller;
use App\Http\Livewire\Paiment\Rapport\RapportFraisByType;
use App\Http\Livewire\Paiment\Rapport\RapportFraisByTypeGeneral;
use Illuminate\Support\Facades\Route;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|Route::get('/', function () {
    return view('dashbaord');
})->name('dashboard');
*/


Route::middleware('auth')->group(function(){
    Route::get('rapport-paiment-type/{type}',RapportFraisByType::class)->name('rapport.frais.type');
    Route::get('rapport-paiment-type-general/{type}',RapportFraisByTypeGeneral::class)
        ->name('rapport.frais.type.general');
    Route::controller(PageController::class)->group(function(){
        Route::get('/','index')->name('dashboard');
        Route::get('gestionnaire-ecole','school')->name('school.index');
        Route::get('gestionnaire-des-frais','cost')->name('cost.index');
        Route::get('gestionnaire-des-inscritions','inscription')->name('inscription.index');
        Route::get('listing-eleve','listing')->name('listing.index');
        Route::get('evolution-inscription','evolutionInscription')->name('evolution.index');
        Route::get('control-paiment','control')->name('control.index');
        Route::get('mouvement-bank','bank')->name('bank.index');
        Route::get('gestion-depenses','depense')->name('depense.index');
        Route::get('adminustration','admin')->name('admin.index');
        Route::get('mon-profile','profile')->name('profile.index');
        Route::get('settings','settings')->name('settings.index');
    });
    Route::controller(PaiementController::class)->group(function(){
        Route::get('paiement-inscription','inscriptionPaiement')->name('paiment.inscription');
        Route::get('paiement-autres-frais','costPaiment')->name('paiment.cost');
        Route::get('rapport-paie-inscription','rapportPaiementInsc')
            ->name('paie.papport.inscription.mounth');

        Route::get('rapport-paie-frais-mounth','rapportPaiementFrais')
            ->name('paie.papport.frais.mounth');

        Route::get('ipression-depense-jour/{date}','printDepenseDate')->name('depense.day.print');
        Route::get('ipression-depense-mois/{month}','printDepenseMonth')->name('depense.month.print');
        Route::get('ipression-depense-periode/{periode}','printDepensePeriode')->name('depense.periode.print');
        Route::get('ipression-paiment/{cost}/{month}/{option}/{inscription_id}','savePaiment')
                ->name('print.paiement.cost');
    });
    Route::controller(DepenseController::class)->group(function(){
        Route::get('ipression-depense-jour/{date}','printDepenseDate')->name('depense.day.print');
        Route::get('ipression-depense-mois/{month}','printDepenseMonth')->name('depense.month.print');
        Route::get('ipression-depense-periode/{periode}','printDepensePeriode')->name('depense.periode.print');


        Route::get('ipression-etatBesoin-jour/{date}','printetatBesoinDate')->name('etatBesoin.day.print');
        Route::get('ipression-etatBesoin-mois/{month}','printetatBesoinMonth')->name('etatBesoin.month.print');
        Route::get('ipression-etatBesoin-periode/{periode}','printetatBesoinPeriode')->name('etatBesoin.periode.print');
        Route::get('ipression-etatBesoin-not-active/{month}','printEtatBesoinNotActive')->name('etatBesoin.not.active.print');

    });
    Route::controller(InscriptionController::class)->group(function(){
        Route::get('ipression-liste/{classe}','printListStudent')->name('students.print');
    });

    Route::controller(PaimentPrinterConteroller::class)->group(function(){
         //RAPPORT DES FRAIS  INSCRIPTION
        Route::get('ipression-paiement-jour/{date}','printRapportInscJournlaier')
                ->name('inscription.paiement.day.print');
        Route::get('ipression-recu-insc/{inscription}','printRecuPaiementInscription')
            ->name('recu.inscription.print');
        Route::get('ipression-recu-frais/{paiment}','printRecuFrais')->name('recu.frais.print');

        Route::get('print-rapport-month-insc/{month}','printRapportInscMonth')
            ->name('inscription.paiement.month.print');

        Route::get('print-rapport-periode-insc/{periode}','printRapportInscPeriode')
            ->name('inscription.paiement.periode.print');

        Route::get('print-rapport-all-insc/{status}/{dateTo}/{dateFrom}/{type}/{classeId}'
                ,'printRapportInscAll')
            ->name('inscription.paiement.all.print');

        //RAPPORT DES AUTRES FRAIS
        Route::get('print-rapport-paiment-frais/{month}/{cost_id}/{type}','printRapportPaiemenFraisMonth')
            ->name('paiement.frais.month.print');

        Route::get('print-rapport-paiment-frais-periode/{periode}/{cost_id}/{month1}/{type}','printRapportPaiemenFraisPeriode')
            ->name('paiement.frais.periode.print');

        Route::get('print-rapport-paiment-frais-day/{date}/{cost_id}/{month2}/{type}','printRapportPaiemenFraisDay')
            ->name('paiement.frais.day.print');

        Route::get('print-rapport-paiment-frais-global/{type}/{cost_id}/{paiement_type}/{classe_id}',
            'printRapportGlobalFrais')->name('paiement.frais.global.print');

        //DEPOT BANK
        Route::get('print-bank-depot/{month}','printDepotBank')->name('bank.depot.print');
    });

    Route::controller(MouvementBankController::class)->group(function(){
        Route::get('print-bank-depot/{month}','printDepotBank')->name('bank.depot.print');
        Route::get('print-bank-depot-all','printDepotBankAll')->name('bank.depot.print.all');
    });
});



