<?php

use App\Http\Controllers\ControlPaimentController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MouvementBankController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PaimentPrinterConteroller;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\RequisitionController;
use App\Http\Livewire\Depense\DepensesByPaiments;
use App\Http\Livewire\Helpers\RapportPaimentHepler;
use App\Http\Livewire\Paiment\Rapport\ArchiveJuinPage;
use App\Http\Livewire\Paiment\Rapport\RapportFraisByType;
use App\Http\Livewire\Paiment\Rapport\RapportFraisByTypeGeneral;
use App\Http\Livewire\Paiment\Rapport\RapportFraisEtatPage;
use App\Http\Livewire\Recettes\RecettesPage;
use Illuminate\Support\Facades\Route;
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

Route::get('/test', function () {
    return (new RapportPaimentHepler())->getPaiementsByType("2022-2023");
});

Route::get('/lit-student', function () {
    return view('dashbaord');

})->name('student.list');


Route::middleware('auth')->group(function(){
    Route::get('rapport-paiment-type/{type}',RapportFraisByType::class)->name('rapport.frais.type');
    Route::get('rapport-paiment-type-general/{type}',RapportFraisByTypeGeneral::class)
        ->name('rapport.frais.type.general');
    Route::get('/depense-in-paiment/{type}',DepensesByPaiments::class)->name('depnses.paiments');
    Route::get('rapport/frais/etat',RapportFraisEtatPage::class)->name("rapport.frais.etat");
    Route::get('archive/juin',ArchiveJuinPage::class)->name("archive.juin");
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


        Route::get('print-depnses-in-paiments-day/{type}/{date}','printDepensePaimentDay')->name('print.depenses.in.paiments.day');
        Route::get('print-depnses-in-paiments-month/{type}/{month}','printDepensePaimentMonth')->name('print.depenses.in.paiments.month');
    });
    Route::controller(InscriptionController::class)->group(function(){
        Route::get('ipression-liste/{classe}','printListStudent')->name('students.print');
        Route::get('rapport-insc-section/{section}','printBySection')->name('print.student.section');
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
        Route::get('print-rapport-paiment-frais/{month}/{cost_id}/{type}/{classeId}/{yearId}',
                    'printRapportPaiemenFraisMonth')
            ->name('paiement.frais.month.print');

        Route::get('print-rapport-paiment-frais-periode/{periode}/{cost_id}/{month1}/{type}/{classeId}/{yearId}'
                    ,'printRapportPaiemenFraisPeriode')
            ->name('paiement.frais.periode.print');

        Route::get('print-rapport-paiment-frais-day/{date}/{cost_id}/{month2}/{type}/{classeId}/{yearId}'
                ,'printRapportPaiemenFraisDay')
            ->name('paiement.frais.day.print');

        Route::get('print-rapport-paiment-frais-global/{type}/{cost_id}/{paiement_type}/{classe_id}/{idScolaryYer}',
            'printRapportGlobalFrais')->name('paiement.frais.global.print');

        Route::get('ipression-paiment-frais-etat/{classeId}/{costId}','printFraisEtat')
            ->name('print.paiement.frais.etat');
        Route::get('ipression-paiment-archive/{classeId}/{costId}/{month}','printArchive')
            ->name('print.paiement.frais.archive');


        //DEPOT BANK
        Route::get('print-bank-depot/{month}','printDepotBank')->name('bank.depot.print');
    });

    Route::controller(ControlPaimentController::class)->group(function(){
        Route::get('print-control-paiment/{classeId}/{costId}/{month}/{scolaryYearId}','printControlPaiment')->name('control.paiment');
        Route::get('print-is-paiment/{classeId}/{costId}/{month}/{scolaryYearId}','printControlIsPaiment')->name('is.paiment');
        Route::get('print-other-paiment/{classeId}/{costId}/{scolaryYearId}','printControlIsOtherPaiment')->name('is.other.paiment');
        Route::get('print-not-other-paiment/{classeId}/{costId}/{scolaryYearId}','printControlNotOtherPaiment')->name('not.other.paiment');
        Route::get('print-all-cpntrol-paiment/{classeId}/{typeId}/{scolaryYearId}','printAllcontrol')->name('control.all.paiment');

        Route::get('print-is-frais-etat-paiment/{costId}/{classeId}','printIsFraiEtat')->name('is.fais.etatpaiment');
        Route::get('print-is-not-frais-etat-paiment/{costId}/{classeId}','printIsNotFraiEtat')->name('is.not.fais.etatpaiment');
    });

    Route::controller(RequisitionController::class)->group(function(){
        Route::get('print-requisition/{id}','printRequisition')->name('requisition.print');
        Route::get('print-requisition-rapport/{status}/{month}/{date}','printRapportRequisition')
        ->name('requisition.rapport.print');
    });

    Route::controller(MouvementBankController::class)->group(function(){
        Route::get('print-bank-depot/{month}','printDepotBank')->name('bank.depot.print');
        Route::get('print-bank-depot-all','printDepotBankAll')->name('bank.depot.print.all');
    });
    Route::get('/recettes',RecettesPage::class)->name('recettes.index');
    Route::controller(RecetteController::class)->group(function(){
        Route::get('/print-recettes/{month}/{scolaryId}','printRecettes')->name('recettes.print');
    });
});



