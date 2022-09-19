<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Depense;
use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class DashbaordFinancePage extends Component
{
    public $recette=0,$depense=0;
    public $currentMonth,$month,$months;
    public $dataRecetteY=[],$dataRecetteLabel=['Entrées','Dépenses'];
    public $isFilterdByDay=true,$date_to_search,$currentDay;
    public $monthsDataY=[],$amountDataX=[];
    public $monthsPaieDataY=[],$amountPaieDataX=[];

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
    }
    public function render()
    {
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

            $depense=Depense::whereMonth('created_at',$this->month)
            ->where('active',true)
            ->sum('amount');
            $depot=DepotBank::whereMonth('created_at',$this->month)
            ->sum('amount');
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

            /*
            $depense=Depense::whereDate('created_at',$this->date_to_search)
            ->sum('amount');
            $depot=DepotBank::whereDate('created_at',$this->date_to_search)
            ->sum('amount');
            */
        }
        $this->recette=($paiment+$inscription)*$this->taux;
        $this->depense=00;
        $this->dataRecetteY=[$this->recette,$this->depense];
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();

        $paimentChart=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->selectRaw(
                "sum(cost_generals.amount) as total,MONTH(paiments.created_at) AS month")
                ->where('paiments.scolary_year_id',$defaultScolaryYer->id)
                ->groupBy('month')
                ->get();

        foreach ($paimentChart as $paiChart) {
            $this->monthsPaieDataY[]= strftime('%B', mktime(0, 0, 0, $paiChart->month));
            $this->amountPaieDataX[]= $paiChart->total*$this->taux;
        }

        $inscChart=Inscription::
            join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
            ->selectRaw(
                "sum(cost_inscriptions.amount) as total,MONTH(inscriptions.created_at) AS month")
            ->where('inscriptions.scolary_year_id',$defaultScolaryYer->id)
            ->where('inscriptions.is_paied',true)
            ->groupBy('month')
            ->get();

        foreach ($inscChart as $insc) {
            $this->monthsDataY[]= strftime('%B', mktime(0, 0, 0, $insc->month));
            $this->amountDataX[]=$insc->total*$this->taux;
        }


        return view('livewire.dashboard.dashbaord-finance-page');
    }
}
