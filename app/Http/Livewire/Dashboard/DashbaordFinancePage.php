<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\Helpers\RapportInscriptionHepler;
use App\Models\Depense;
use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\Requisition;
use App\Models\ScolaryYear;
use Livewire\Component;

class DashbaordFinancePage extends Component
{
    public $recette=0,$depense=0;
    public $currentMonth,$month,$months;
    public $dataRecetteY=[],$dataRecetteLabel=['Dépenses','Entrées'];
    public $isFilterdByDay=true,$date_to_search,$currentDay;
    public $monthsDataY=[],$amountDataX=[];
    public $monthsPaieDataY=[],$amountPaieDataX=[];

    public $înscriptionByTypes;
    public $taux=2000;

    public function updatedDateToSearch(){
        $this->isFilterdByDay=true;
    }

    public function updatedMonth(){
        $this->isFilterdByDay=false;
    }
    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->currentDay=date('Y-m-d');
        $this->date_to_search=$this->currentDay;
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }

       $this->înscriptionByTypes= (new RapportInscriptionHepler())->getPaiementsByType();
    }
    public function render()
    {
        $total_details=0;$total=0;
        if ($this->isFilterdByDay==false) {
            $inscription=Inscription::
                join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                ->whereMonth('inscriptions.created_at',$this->month)
                ->where('inscriptions.is_paied',true)
                ->sum('cost_inscriptions.amount');
            $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->whereMonth('paiments.created_at',$this->month)
                ->where('paiments.is_paied',true)
                ->sum('cost_generals.amount');
            $depenses=Requisition::whereMonth('created_at',$this->month)
                ->where('active',true)
                ->get();
                foreach ($depenses as  $depense) {
                    foreach ($depense->details as $detail) {
                        if ($detail->active==true) {
                            $total_details+=$detail->amount;
                        }
                    }
                    $total+=$total_details;
                }
                $this->depense=$total;
            $this->emit('refreshChart',);
        } else {
            $inscription=Inscription::
                join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                ->whereDate('inscriptions.created_at',$this->date_to_search)
                ->where('inscriptions.is_paied',true)
                ->sum('cost_inscriptions.amount');
            $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->whereDate('paiments.created_at',$this->date_to_search)
                ->sum('cost_generals.amount');
            $depenses=Requisition::whereDate('created_at',$this->date_to_search)
                ->where('active',true)
                ->get();
            foreach ($depenses as  $depense) {
                foreach ($depense->details as $detail) {
                    if ($detail->active==true) {
                        $total_details+=$detail->amount;
                    }
                }
                $total=$total_details;
            }
        }
        $this->depense=$total;
        $this->recette=($paiment+$inscription)*$this->taux;

        $this->dataRecetteY=[$this->depense,$this->recette];

        return view('livewire.dashboard.dashbaord-finance-page');
    }
}
