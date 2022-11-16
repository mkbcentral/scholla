<?php

namespace App\Http\Livewire\Paiment;

use App\Http\Livewire\Helpers\InscriptionHelper;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListingPaimentPage extends Component
{
    public $month_name='',$months=[],$currentMonth,$inscription,$isc_id=0;
    public $paiments=[],$studentPaiements=[],$inscriptionToShow;
    public  $taux=2000;
    public $month_select='',$cost_select=0;
    public $cost,$cost_price=0,$cost_id=0;
    public $option_id=0;

    public $keySearch='';

    public function mount(){
        $this->costs=CostGeneral::orderBy('name','ASC')->where('active',true)->get();
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }

    public function getGetPaiementDay(){
        $this->paiments=Paiment::whereDate('created_at',date('Y-m-d'))
                        ->with('student.classe.option')
                        ->get();
    }

    public function show(Inscription $inscription){
        $this->inscription=$inscription;
        $this->isc_id=$inscription->id;
        $this->option_id=$inscription->student->classe->option->id;
    }

    public function getCost($id){

        $this->cost=CostGeneral::find($id);
        $this->cost_price=$this->cost->amount*2000;
    }

    public function getPaiements($id,$id_ins){
        $this->inscriptionToShow=Inscription::find($id_ins);
        $this->studentPaiements=Paiment::where('student_id',$id)->get();
    }

    public function validatePaiement(){

        $months_arry=array();
        for ($i=1; $i <= 12 ; $i++) {
           if ($i !=  7 && $i != 8) {
                if ($i<=9) {
                    $n=sprintf('%02d',$i);
                }else{
                    $n=$n=sprintf('%01d',$i);;
                }
                //echo 'Mont is: '.$n.'<br>';
                $months_arry[$i]=$n;
           }
        }
        //dd($months_arry);
        $paiments=Paiment::select( DB::raw('MONTH(paiments.created_at) as mounth'))
            ->join('students','paiments.student_id','=','students.id')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->where('paiments.scolary_year_id',1)
            ->where('students.id',$this->inscription->student->id)
            ->get();
        //dd($paiments);
        $month_paiment='';
        foreach ($months_arry as  $m) {
           foreach ($paiments as  $p) {
                echo $p;
           }
        }

        /*
        $paiement=new Paiment();
        $paiement->scolary_year_id=$this->defaultScolaryYer->id;
        $paiement->cost_general_id=$this->cost_id;
        $paiement->student_id=$this->inscription->student->id;
        $paiement->classe_id=$this->inscription->student->classe->id;
        $paiement->mounth_name=$this->month_name;
        $paiement->number_paiement=$this->generateNumberPaiement();
        $paiement->user_id=auth()->user()->id;
        $paiement->save();
        $this->testPrint($paiement);

        $this->dispatchBrowserEvent('data-added',['message'=>"Paiment bien validé !"]);
        */

    }



    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $inscriptions= (new InscriptionHelper())->getByScolaryYear($this->defaultScolaryYer->id,$this->keySearch);
        return view('livewire.paiment.listing-paiment-page',['inscriptions'=>$inscriptions]);
    }
}
