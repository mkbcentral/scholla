<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\EtatBesoin;
use App\Models\Paiment;
use App\Models\TypeOtherCost;
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

    public function printDepensePaimentDay($type,$day){
        $paiments=Paiment::select('students.*','paiments.*')
        ->join('students','paiments.student_id','=','students.id')
        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
        ->where('paiments.scolary_year_id',1)
        ->whereDate('paiments.created_at',$day)
        ->where('cost_generals.type_other_cost_id',$type)
        ->where('paiments.is_depense',true)
        ->orderBy('paiments.created_at','DESC')
        ->with('cost')
        ->with('student')
        ->with('student.classe')
        ->with('student.classe.option')
        ->get();
        $motif=TypeOtherCost::find($type);
        $taux=2000;
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.depense.prints.print-depenses-paiment-day',
        compact(['paiments','day','motif','day','taux']));
        return $pdf->stream();
    }

    public function printDepensePaimentMonth($type,$month){
        $paiments=Paiment::select('students.*','paiments.*')
        ->join('students','paiments.student_id','=','students.id')
        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
        ->where('paiments.scolary_year_id',1)
        ->whereMonth('paiments.created_at',$month)
        ->where('cost_generals.type_other_cost_id',$type)
        ->where('paiments.is_depense',true)
        ->orderBy('paiments.created_at','DESC')
        ->with('cost')
        ->with('student')
        ->with('student.classe')
        ->with('student.classe.option')
        ->get();
        $taux=2000;
        $motif=TypeOtherCost::find($type);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.depense.prints.print-depenses-paiment-month',
        compact(['paiments','motif','month','taux']));
        return $pdf->stream();
    }
}
