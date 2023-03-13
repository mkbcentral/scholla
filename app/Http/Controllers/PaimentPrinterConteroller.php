<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Helpers\PaimentHelper;
use App\Models\Classe;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\Section;
use App\Models\TypeOtherCost;
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
                    ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
                    ->where('inscriptions.is_paied',true)
                    ->orderBy('students.name','ASC')
                    ->whereDate('inscriptions.created_at',$date)
                    ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-paiment-insc-journ',
            compact(['defaultScolaryYer','inscriptions','taux','date']));
        return $pdf->stream();

    }

    public function printRapportInscAll($status,$dateTo,$dateFrom,$type,$classe_id){
        $taux=2000;
        $classe=null;
        if ($classe_id !=0 ) {
           $classe=Classe::find($classe_id);
        }
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($classe_id==0) {
            if ($status==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
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
                ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
                ->orderBy('inscriptions.created_at','ASC')
                ->where('inscriptions.is_paied',true)
                ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
        } else {
            if ($status==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
                ->orderBy('inscriptions.created_at','DESC')
                ->where('inscriptions.is_paied',true)
                ->where('inscriptions.classe_id',$classe_id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
                ->orderBy('inscriptions.created_at','ASC')
                ->where('inscriptions.is_paied',true)
                ->where('inscriptions.classe_id',$classe_id)
                ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
        }


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-all-paiment-insc',
            compact(['defaultScolaryYer','inscriptions','taux','dateTo','dateFrom','status','classe']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
        return $pdf->stream();

    }

    public function printRapportInscMonth($month){
        $taux=2000;
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
            $inscriptions=Inscription::select('students.name','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                    ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
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
            ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
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
            ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
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
                ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
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
    public function printRapportPaiemenFraisDay($date,$cost_id,$month,$type,$classe_id,$idScolaryYer){
        $taux=2000;
        $motif='';
        $myType=TypeOtherCost::find($type);
        $motif=$myType->name;
        $defaultScolaryYer=ScolaryYear::find($idScolaryYer);
        $paiments=(new PaimentHelper())
                        ->getDatePaiments(
                            $date,
                            $idScolaryYer,
                            $cost_id,
                            $type,
                            $classe_id,''
                        );
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-day',
            compact(['defaultScolaryYer','paiments','taux','date','motif','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printRapportPaiemenFraisMonth($month,$cost_id,$type,$classeId,$idScolaryYer){
        $taux=2000;
        $motif='';
        $defaultScolaryYer=ScolaryYear::find($idScolaryYer);
        $myType=TypeOtherCost::find($type);
        $motif=$myType->name;
        $paiments=(new PaimentHelper())
                    ->getMonthPaiments(
                        $month,
                        $idScolaryYer,
                        $cost_id,
                        $type,
                        $classeId,'');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-month',
            compact(['defaultScolaryYer','paiments','taux','month','motif']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printRapportPaiemenFraisPeriode($periode,$cost_id,$month,$type,$classe_id,$idScolaryYer){
        $taux=2000;
        $motif='';
        $label='';
        $defaultScolaryYer=ScolaryYear::find($idScolaryYer);
        $myType=TypeOtherCost::find($type);
        $motif=$myType->name;
        if ($periode==1) {
            $paiments=(new PaimentHelper())
            ->getCureentWeekPaiement(
                $idScolaryYer,
                $cost_id,
                $type,
                $classe_id,''
            );
            $label="Semaine en cours";
        } elseif($periode==2) {
            $paiments=(new PaimentHelper())
            ->getPassWeekPaiement(
                $idScolaryYer,
                $cost_id,
                $type,
                $classe_id,'');
                $label="Semaine passée";
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-paiement-frais-periode',
            compact(['defaultScolaryYer','paiments','taux','label','motif','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printRapportGlobalFrais($type,$cost_id,$paiement_type,$classe_id,$idScolaryYer){
        $taux=2000;
        $motif='';
        $myTypeData='';
        if ($myTypeData=="Tout") {
            # code...
        } else {
            $myTypeData=$type;
        }

        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $myType=TypeOtherCost::find($paiement_type);
        $motif=$myType->name;
        if ($classe_id ==0) {
            $classe=null;
        }else{
            $classe=Classe::find($classe_id);
        }

        if ($cost_id==0) {
            if ($classe_id==0) {
                if ($type=="Tout") {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                } else if($type=="Dépot banque"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_bank',true)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Fonctionnement"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_fonctionnement',true)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Dépenses"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_depense',true)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }
            } else {
                if ($type=="Tout") {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                } else if($type=="Dépot banque"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_bank',true)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Fonctionnement"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_fonctionnement',true)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Dépenses"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_depense',true)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }
            }
        } else {
            if ($classe_id==0) {
                if ($type=="Tout") {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                } else if($type=="Dépot banque"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_bank',true)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Fonctionnement"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_fonctionnement',true)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Dépenses"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_depense',true)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }
            } else {
                if ($type=="Tout") {
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('cost_general_id',$cost_id)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                } else if($type=="Dépot banque"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_bank',true)
                    ->where('cost_general_id',$cost_id)
                    ->where('paiments.classe_id',$classe_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Fonctionnement"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_fonctionnement',true)
                    ->where('paiments.classe_id',$classe_id)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }else if($type=="Dépenses"){
                    $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                    ->where('cost_generals.type_other_cost_id',$myType->id)
                    ->where('paiments.is_depense',true)
                    ->where('paiments.classe_id',$classe_id)
                    ->where('cost_general_id',$cost_id)
                    ->orderBy('paiments.created_at','DESC')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
                }
            }

        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-global-frais',
            compact(['defaultScolaryYer','paiments','taux','motif','classe','myTypeData']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();


    }

    public function printFraisEtat($classeId,$costId){
        $taux=2000;
        $cost=CostGeneral::find($costId);
        $classe=Classe::find($classeId);
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('cost_generals.type_other_cost_id',6)
            ->where('cost_generals.id',$costId)
            ->where('paiments.classe_id',$classeId)
            ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
            ->get();
        //dd($paiments);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-frais-etat',
            compact(['defaultScolaryYer','paiments','cost','classe','taux']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printFraisEtatByDate($date){
        $taux=2000;
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('cost_generals.type_other_cost_id',6)
            ->whereDate('paiments.created_at',$date)
            ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
            ->get();
        //dd($paiments);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-frais-etat-by-date',
            compact(['defaultScolaryYer','paiments','date','taux']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printFraisEtatBySection($sectionId,$costId){
        $taux=2000;
        $section=Section::find($sectionId);
        $defaultScolaryYer = ScolaryYear::where('active', true)->first();
        if ($costId== 0) {
            $paiments = Paiment::select('paiments.*', 'cost_generals.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', 6)
                ->where('sections.id', $sectionId)
                ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
        } else {
            $paiments = Paiment::select('paiments.*', 'cost_generals.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', 6)
                ->where('paiments.cost_general_id', $costId)
                ->where('sections.id', $sectionId)
                ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
        }
        //dd($paiments);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-frais-etat-soection',
            compact(['defaultScolaryYer','paiments','section','taux']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printArchive($classeId,$costId,$month){
        $taux=2000;
        $cost=CostGeneral::find($costId);
        $classe=Classe::find($classeId);
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('paiments.mounth_name',$month)
            ->where('cost_generals.id',$costId)
            ->where('paiments.classe_id',$classeId)
            ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-frais-archive',
            compact(['defaultScolaryYer','paiments','cost','classe','taux','month','costId']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }

    public function printArchiveGlobal($costId,$month){
        $taux=2000;
        $cost=CostGeneral::find($costId);
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($costId==0) {
            $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('paiments.mounth_name',$month)
            ->whereIn('cost_generals.id',[37,38,40,41,42])
            ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
            ->get();
        } else {
            $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('paiments.mounth_name',$month)
            ->where('cost_generals.id',$costId)
            ->where('paiments.scolary_year_id', $defaultScolaryYer->id)
            ->get();
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-rapport-frais-archive-global',
            compact(['defaultScolaryYer','paiments','cost','taux','month','costId']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');
            return $pdf->stream();
    }



}
