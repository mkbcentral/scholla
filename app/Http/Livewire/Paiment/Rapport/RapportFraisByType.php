<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Http\Livewire\Helpers\PaimentHelper;
use App\Models\Classe;
use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Carbon\Carbon;
use Livewire\Component;

class RapportFraisByType extends Component
{
    public $type,$typeData,$scolaryyears,$scolary_id,$defaultScolaryYer;
    public $month,$months=[],$currentMonth;
    public $taux=2000,$periode,$classes,$classe_id=0;
    public $itemsPeriodeFilter=['Semain en cours','Semaine passée'];
    public  $isMonthSorted=true,$itmePeriodSorted=0,$isDaySorted=false,$status="Min";
    public $costs=[],$cost_id=0,$date_to_search='',$paiment_date,$number_paiment,$paimentToDelete;
    protected $listeners=['paimentOtherListener'=>'delete'];

    public $paiment;

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }
    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->costs=CostGeneral::orderBy('name','ASC')
            ->where('active',true)
            ->where('scolary_year_id', $this->defaultScolaryYer->id)
            ->where('type_other_cost_id',$this->type)
            ->get();
        $this->typeData=TypeOtherCost::find($this->type);
        $this->classes=Classe::orderBy('name','ASC')->with('option')->get();
        $this->scolaryyears=ScolaryYear::all();

    }
    public function edit(Paiment $paiment){
        $this->paiment=$paiment;
        $this->number_paiment=$paiment->number_paiement;
        $this->paiment_date=$paiment->created_at->format('d/m/Y');
    }
    public function updateNumber(){
        $this->validate(['number_paiment'=>'required']);
        $this->paiment->number_paiement=$this->number_paiment;
        $this->paiment->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Numero frais bien mise à jour !"]);
    }

    public function showDeleteDialog(Paiment $paiment){
        $this->paimentToDelete=$paiment;
        $this->dispatchBrowserEvent('delete-pamient-other-dialog');
    }

    public function delete(){
        $this->paimentToDelete->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Paiement bien retiré !"]);
    }
    public function updatedDateToSearch(){
        $this->itmePeriodSorted=0;
        $this->isMonthSorted=false;
        $this->isDaySorted=true;
    }
    public function updatedMonth(){
        $this->itmePeriodSorted=0;
        $this->isMonthSorted=true;
        $this->isDaySorted=false;
    }

    public function refreshData(){
        $this->mounth=date('y-m-d');
    }

    public function render()
    {
        if ($this->periode=="Semain en cours") {
            $paiments=(new PaimentHelper())
            ->getCureentWeekPaiement($this->defaultScolaryYer->id,$this->cost_id,$this->type,$this->classe_id);
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=1;
        } elseif($this->periode=="Semaine passée") {

            $paiments=(new PaimentHelper())
                ->getPassWeekPaiement($this->defaultScolaryYer->id,$this->cost_id,$this->type,$this->classe_id);
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=2;
        }else{
            if ($this->isMonthSorted==true) {
                $paiments=(new PaimentHelper())
                    ->getMonthPaiments(
                        $this->month,
                        $this->defaultScolaryYer->id,
                        $this->cost_id,
                        $this->type,
                        $this->classe_id);
            } else {
                $paiments=
                    (new PaimentHelper())
                    ->getDatePaiments(
                           $this->date_to_search,
                            $this->defaultScolaryYer->id,
                            $this->cost_id,
                            $this->type,
                            $this->classe_id);

            }
        }
        return view('livewire.paiment.rapport.rapport-frais-by-type',['paiments'=>$paiments]);
    }
}
