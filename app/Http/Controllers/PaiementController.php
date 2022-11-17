<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScolaryYear;
use App\Models\Paiment;
use App\Models\Inscription;
use App\Models\ClasseOption;
use Illuminate\Support\Facades\App;

class PaiementController extends Controller
{
    public function inscriptionPaiement(){
        return view('pages.paiement.inscription-paiemrent');
    }

    public function costPaiment(){
        return view('pages.paiement.cost-paiement');
    }

    public function rapportPaiementInsc(){
        return view('pages.paiement.rapport-paiement-insc');
    }

    public function rapportPaiementFrais(){
        return view('pages.paiement.rapport-paiement-autres-frais');
    }

    public function savePaiment($cost_id,$month,$option_id,$inscription_id){
        //dd($cost_id.' '.$month.' '.$option.' '.$inscription_id);
        $taux=2000;
        $inscription=Inscription::find($inscription_id);
        $option=ClasseOption::find($option_id);
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $paiement=new Paiment();
        $paiement->scolary_year_id=$defaultScolaryYer->id;
        $paiement->cost_general_id=$cost_id;
        $paiement->student_id=$inscription->student->id;
        $paiement->classe_id=$inscription->student->classe->id;
        $paiement->mounth_name=$month;
        $paiement->number_paiement=$this->generateNumberPaiement($option);
        $paiement->user_id=auth()->user()->id;
        /*
        $paiementExist=Paiment::where('student_id',$inscription->student->id)
                                ->where('mounth_name',$month)
                                ->where('scolary_year_id',$defaultScolaryYer->id)
                               ->first();
        if ($paiementExist) {
           dd($paiementExist);
        }else{

        }
        */
        $paiement->save();
        $paiement->is_paied=true;
        $paiement->update();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.paiement.pints.print-recu-paiment',
            compact(['paiement','taux']));
        return $pdf->stream();



    }

    public function generateNumberPaiement($option){
        $number=0;
        if($option->name=='Primaire'){
            $number=rand(99,1000).'-P';
        }else if($option->name=='Maternelle'){
            $number=rand(99,1000).'-M';
        }else{
            $number=rand(99,1000).'-S';
        }
        return $number;
    }


}
