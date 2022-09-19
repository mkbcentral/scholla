<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Http\Livewire\Helpers\InscriptionHelper;
use App\Models\Classe;
use App\Models\CostInscription;
use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use Carbon\Carbon;
use Livewire\Component;

class RapportInscriptionPaimentPage extends Component
{
    public $month,$months=[],$currentMonth;
    public $taux=2000,$periode,$keySearch='';
    public $itemsPeriodeFilter=['Semain en cours','Semaine passée'],$scolaryyears,$scolary_id;
    public  $isMonthSorted=true,$itmePeriodSorted=0;
    public $date_to_search,$classes,$classe_id=0,$costs,$cost_id=0;

    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->classes=Classe::orderBy('name','ASC')->with('option')->get();
        $this->costs=CostInscription::all();
        $this->scolaryyears=ScolaryYear::all();
    }
    public function refreshData(){
        $this->mounth=date('y-m-d');
    }
    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }
    public function render()
    {
        if ($this->periode=="Semain en cours") {
            $inscriptions=(new InscriptionHelper())->getCurrentWeekInscriptions($this->defaultScolaryYer->id,$this->classe_id,$this->cost_id,$this->keySearch);
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=1;
            $depot=0;
        } elseif($this->periode=="Semaine passée") {
            $inscriptions=(new InscriptionHelper())
                ->getPassWeekInscriptions($this->defaultScolaryYer->id,$this->classe_id,$this->cost_id,$this->keySearch);
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=2;
            $depot=0;
        }else{
            $inscriptions=(new InscriptionHelper())
                ->getMonthInscriptions($this->month,$this->defaultScolaryYer->id,$this->classe_id,$this->cost_id,$this->keySearch);

            $this->isMonthSorted=true;
            $depot=DepotBank::whereMonth('created_at',$this->month)->sum('amount');
        }
        return view('livewire.paiment.rapport.rapport-inscription-paiment-page',
                ['inscriptions'=>$inscriptions,'depot'=>$depot]);
    }
}
