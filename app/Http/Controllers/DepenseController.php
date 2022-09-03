<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\EtatBesoin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DepenseController extends Controller
{
    public function printDepenseDate($date){
        $depenses=Depense::where('is_trashed',false)
                ->whereDate('created_at',$date)
                ->where('active',true)
                ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-depenses-day',
        compact(['depenses','date']));
        return $pdf->stream();
    }
    public function printDepenseMonth($month){
        $depenses=Depense::where('is_trashed',false)
                ->whereMonth('created_at',$month)
                ->where('active',true)
                ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-depenses-month',
        compact(['depenses','month']));
        return $pdf->stream();
    }
    public function printDepensePeriode($periode){
        $label='';
        if ($periode==1) {
            $depenses=Depense::where('is_trashed',false)
            ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('active',true)
            ->get();
            $label="Semaine en cours";
        } elseif($periode==2) {
            $date=Carbon::now()->subDays(7);
            $depenses=Depense::where('is_trashed',false)
                        ->where('created_at', '>=', $date)
                        ->where('active',true)
                        ->get();
            $label="Semaine en cours";
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-depenses-periode',
        compact(['depenses','label']));
        return $pdf->stream();
    }


    public function printEtatBesoinDate($date){
        $etatBesoins=EtatBesoin::where('is_trashed',false)
                ->whereDate('created_at',$date)
                ->where('active',true)
                ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-etatBesoins-day',
        compact(['etatBesoins','date']));
        return $pdf->stream();
    }
    public function printEtatBesoinMonth($month){
        $etatBesoins=EtatBesoin::where('is_trashed',false)
                ->whereMonth('created_at',$month)
                ->where('active',true)
                ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-etatBesoins-month',
        compact(['etatBesoins','month']));
        return $pdf->stream();
    }

    public function printetatBesoinsPeriode($periode){
        $label='';
        if ($periode==1) {
            $etatBesoins=EtatBesoin::where('is_trashed',false)
            ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('active',true)
            ->get();
            $label="Semaine en cours";
        } elseif($periode==2) {
            $date=Carbon::now()->subDays(7);
            $etatBesoins=Depense::where('is_trashed',false)
                        ->where('created_at', '>=', $date)
                        ->where('active',true)
                        ->get();
            $label="Semaine en cours";
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-etatBesoins-periode',
        compact(['etatBesoins','label']));
        return $pdf->stream();
    }

    public function printEtatBesoinNotActive($month){
        $etatBesoins=EtatBesoin::where('is_trashed',false)
                ->whereMonth('created_at',$month)
                ->where('active',false)
                ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.depense.prints.print-etatBesoin-not-active',
        compact(['etatBesoins','month']));
        return $pdf->stream();
    }
}
