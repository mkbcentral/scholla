<?php

namespace App\Http\Livewire\Paiment;

use App\Http\Livewire\Helpers\InscriptionHelper;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class ListingPaimentPage extends Component
{
    public $month_name='',$months=[],$currentMonth,$inscription,$isc_id=0;
    public $paiments=[];
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



    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $inscriptions= (new InscriptionHelper())->getByScolaryYear($this->defaultScolaryYer->id,$this->keySearch);
        return view('livewire.paiment.listing-paiment-page',['inscriptions'=>$inscriptions]);
    }
}
