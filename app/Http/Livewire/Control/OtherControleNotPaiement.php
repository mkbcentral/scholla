<?php

namespace App\Http\Livewire\Control;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class OtherControleNotPaiement extends Component
{
    public $selectedIndex=0;
    public $classes,$classe_id=0,$cost_id=0,$scolaryyears,$scolary_id;
    public $keySearch='';
    public $state=[],$costs=[];
    public $defaultScolaryYer,$options=[];
    public $month_name,$months=[],$currentMonth,$inscription;
    public $paiments=[];
    public  $taux=2000;
    public $days=[];
    public $tranches=[],$tranche_id=0;

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function mount()
    {
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,10));
        }

        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $defualtOption=ClasseOption::where('name','Primaire')->first();
        $this->selectedIndex=$defualtOption->id;

        $this->option=$defualtOption;

        $this->costs=TypeOtherCost::where('active',true)
            ->where('scolary_year_id', $this->defaultScolaryYer->id)
            ->get();


        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $this->scolaryyears=ScolaryYear::all();


    }

    public function render()
    {
        $days_numbers= cal_days_in_month(CAL_GREGORIAN, $this->month, date('Y'));
            $days_arry=array();
            for ($i=1; $i <= $days_numbers; $i++) {
                if ($i>= 25) {
                    $days_arrys[$i]=$i;
                }
            }
        $this->days=$days_arrys;
        $this->classes=Classe::orderBy('name','ASC')
            ->with('option')
            ->get();
            $items = array();

            $paiments=Paiment::select('paiments.*','cost_generals.*')
                ->where('paiments.classe_id',$this->classe_id)
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                ->where('paiments.cost_general_id',$this->tranche_id)
                ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                ->with(['student.classe.option'])
                ->get();

            foreach ($paiments as $paiment) {
                $items[] = $paiment->student_id;
            }
            //dd($items);
            $inscriptions=Inscription::whereNotIn('student_id',$items)
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$this->classe_id)
                        ->where('scolary_year_id', $this->defaultScolaryYer->id)
                        ->orderBy('students.name','ASC')
                        ->with(['student.classe.option'])
                        ->get();
            $this->tranches=CostGeneral::where('type_other_cost_id',$this->cost_id)->get();
        return view('livewire.control.other-controle-not-paiement',['inscriptions'=>$inscriptions]);
    }
}
