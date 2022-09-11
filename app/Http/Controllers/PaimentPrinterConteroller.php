<?php

namespace App\Http\Controllers;

use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PaimentPrinterConteroller extends Controller
{
    public function printRecuPaiementInscription($inscriptions){
        $paiement=Inscription::find($inscriptions);
        $taux=2000;
        $paiement->is_paied=true;
        $paiement->update();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-recu-inscription',
            compact(['paiement','taux']));
        return $pdf->stream();
    }

    public function printRecuFrais($paiement){
        $paiement=Paiment::find($paiement);
        $taux=2000;
        $paiement->update();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-recu-paiment',
            compact(['paiement','taux']));
        return $pdf->stream();
    }

    public function printRapportInscJournlaier($date){
        $taux=2000;
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
            $inscriptions=Inscription::select('students.name','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->where('inscriptions.is_paied',true)
                    ->orderBy('students.name','ASC')
                    ->whereDate('inscriptions.created_at',$date)
                    ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-paiment-insc-journ',
            compact(['defaultScolaryYer','inscriptions','taux','date']));
        return $pdf->stream();

    }

    public function printRapportInscAll($status,$dateTo,$dateFrom){
        $taux=2000;
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($status==0) {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$defaultScolaryYer->id)
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        } else {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$defaultScolaryYer->id)
            ->orderBy('inscriptions.created_at','ASC')
            ->where('inscriptions.is_paied',true)
            ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-all-paiment-insc',
            compact(['defaultScolaryYer','inscriptions','taux','dateTo','dateFrom','status']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
        return $pdf->stream();

    }

    public function printRapportInscMonth($month){
        $taux=2000;
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
            $inscriptions=Inscription::select('students.name','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->where('inscriptions.is_paied',true)
                    ->orderBy('students.name','ASC')
                    ->whereMonth('inscriptions.created_at',$month)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiment-insc-mounth',
            compact(['defaultScolaryYer','inscriptions','taux','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
        return $pdf->stream();

    }

    public function printRapportInscPeriode($periode){
        $taux=2000;
        $label='';
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($periode==1) {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$defaultScolaryYer->id)
            ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $label="Semaine en cours";
        } elseif($periode==2) {
            $date=Carbon::now()->subDays(7);
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$defaultScolaryYer->id)
            ->where('inscriptions.created_at', '>=', $date)
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $label="Semaine passée";
        }
        elseif($periode==3) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereYear('inscriptions.created_at',Carbon::now())
                ->orderBy('inscriptions.created_at','DESC')
                ->where('inscriptions.is_paied',true)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $label="Année en cours";
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiment-insc-periode',
            compact(['defaultScolaryYer','inscriptions','taux','label']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
        return $pdf->stream();

    }

    //PAPPORT PAIMPENT AUTRES FRAIS
    public function printRapportPaiemenFraisDay($date,$cost_id,$status,$month){
        $taux=2000;
        $motif='';
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($status=="Autres") {
            if ($cost_id==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereDate('paiments.created_at',$date)
                ->orderBy('paiments.created_at','DESC')
                ->whereIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $motif="Pour tous les frais";
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereDate('paiments.created_at',$date)
                ->orderBy('paiments.created_at','DESC')
                ->where('cost_general_id',$cost_id)
                ->whereIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $cost=CostGeneral::find($cost_id);
                $motif=$cost->name;
            }
        } else {
            if ($cost_id==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereDate('paiments.created_at',$date)
                ->orderBy('paiments.created_at','DESC')
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $motif="Pour tous les frais";
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereDate('paiments.created_at',$date)
                ->orderBy('paiments.created_at','DESC')
                ->where('cost_general_id',$cost_id)
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $cost=CostGeneral::find($cost_id);
                $motif=$cost->name;
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-day',
            compact(['defaultScolaryYer','paiments','taux','date','motif','status','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printRapportPaiemenFraisMonth($month,$cost_id,$status){
        $taux=2000;
        $motif='';
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($status=='Autres') {
            if ($cost_id==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereMonth('paiments.created_at',$month)
                ->orderBy('paiments.created_at','DESC')
                ->whereIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $motif="Pour tous les frais";
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereMonth('paiments.created_at',$month)
                ->orderBy('paiments.created_at','DESC')
                ->where('cost_general_id',$cost_id)
                ->whereIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $cost=CostGeneral::find($cost_id);
                $motif=$cost->name;
            }
        } else {
            if ($cost_id==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereMonth('paiments.created_at',$month)
                ->orderBy('paiments.created_at','DESC')
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $motif="Pour tous les frais";
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereMonth('paiments.created_at',$month)
                ->orderBy('paiments.created_at','DESC')
                ->where('cost_general_id',$cost_id)
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $cost=CostGeneral::find($cost_id);
                $motif=$cost->name;
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-month',
            compact(['defaultScolaryYer','paiments','taux','month','motif','status']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printRapportPaiemenFraisPeriode($periode,$cost_id,$status,$month){
        $taux=2000;
        $motif='';
        $label='';
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($periode==1) {
            if ($status=="Autres") {
                if ($cost_id==0) {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->whereIn('cost_generals.id',[8,10,13,14])
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                    $motif="Pour tous les frais";
                } else {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->whereIn('cost_generals.id',[8,10,13,14])
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$cost_id)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                    $cost=CostGeneral::find($cost_id);
                    $motif=$cost->name;
                }
            } else {
                if ($cost_id==0) {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->whereNotIn('cost_generals.id',[8,10,13,14])
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                    $motif="Pour tous les frais";
                } else {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->whereNotIn('cost_generals.id',[8,10,13,14])
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$cost_id)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                    $cost=CostGeneral::find($cost_id);
                    $motif=$cost->name;
                }
            }


            $label="Semaine en cours";
        } elseif($periode==2) {
            if ($cost_id==0) {
                $date=Carbon::now()->subDays(7);
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->where('paiments.created_at', '>=', $date)
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $motif="Pour tous les frais";
            } else {
                $date=Carbon::now()->subDays(7);
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$defaultScolaryYer->id)
                ->whereNotIn('cost_generals.id',[8,10,13,14])
                ->where('paiments.created_at', '>=', $date)
                ->orderBy('paiments.created_at','DESC')
                ->where('cost_general_id',$cost_id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $cost=CostGeneral::find($cost_id);
                $motif=$cost->name;
            }
            $label="Semaine passée";
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-periode',
            compact(['defaultScolaryYer','paiments','taux','label','motif','status','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }


}
