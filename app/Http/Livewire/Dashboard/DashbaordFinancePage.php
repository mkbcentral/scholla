<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\Helpers\RapportInscriptionHepler;
use App\Models\Depense;
use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\Requisition;
use App\Models\ScolaryYear;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashbaordFinancePage extends Component
{
    public $recette=0,$depense=0;
    public $currentMonth,$month,$months;
    public $dataRecetteY=[],$dataRecetteLabel=['Dépenses','Entrées'];
    public $isFilterdByDay=true,$date_to_search,$currentDay;
    public $monthsDataY=[],$amountDataX=[];
    public $monthsDataInscY=[],$amountDataInscX=[];
    public $monthsPaieDataY=[],$amountPaieDataX=[];
    public $valuesMonthY=[],$valueAmountX=[],$valuesPaie;

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
                ->where('paiments.mounth_name',$this->month)
                //->where('paiments.is_paied',true)
                ->sum('cost_generals.amount');
                //dd($inscription);
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

        //All paiement group by month
        $paimentMonth=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->select(
                    DB::raw('sum(cost_generals.amount) as amount'),
                    DB::raw("paiments.mounth_name as month"),
                )
                ->groupBy('month')
                ->get();

        $arrayMonthData=array();
        $arrayAmountData=array();
        foreach ($paimentMonth as $paie) {
            $dateObj = DateTime::createFromFormat('!m', $paie->month);
            $monthName = $dateObj->format('F');
            $arrayMonthData[]=$monthName;
            $arrayAmountData[]=$paie->amount*2000;
        }
        $this->valuesMonthY=array_reverse($arrayMonthData);
        $this->amountDataX=array_reverse($arrayAmountData);

        //All inscriptions group by month
        $inscriptionsMonth=Inscription::join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                ->select(
                    DB::raw('sum(cost_inscriptions.amount) as amount'),
                    DB::raw("(DATE_FORMAT(inscriptions.created_at, '%m')) as month")
                )
                ->groupBy('month')
                ->get();
        //dd($inscriptionsMonth);
        $arrayMonthDataInsc=array();
        $arrayAmountDataInsc=array();
        foreach ($inscriptionsMonth as $insc) {
            $dateObj2 = DateTime::createFromFormat('!m', $insc->month);
            $monthNameInsc = $dateObj2->format('F');
            $arrayMonthDataInsc[]=$monthNameInsc;
            $arrayAmountDataInsc[]=$insc->amount*2000;
        }
        $this->monthsPaieDataY=array_reverse($arrayMonthDataInsc);
        $this->amountDataInscX=array_reverse($arrayAmountDataInsc);
        return view('livewire.dashboard.dashbaord-finance-page');
    }
}
