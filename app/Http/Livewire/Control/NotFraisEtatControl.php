<?php

namespace App\Http\Livewire\Control;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostGeneral;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class NotFraisEtatControl extends Component
{
    public $classes,$classe_id=0,$cost_id=0,$scolaryyears,$scolary_id;
    public $keySearch='';
    public $state=[],$costs=[];
    public $defaultScolaryYer,$options=[];
    public $month_name,$months=[],$currentMonth,$inscription;
    public $paiments=[];
    public  $taux=2000;
    public $days=[];
    public $typeFrais=[],$type_id=0;

    public function mount()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $this->costs=CostGeneral::where('type_other_cost_id',6)->get();

        $this->classes=Classe::orderBy('name','ASC')
            ->with('option')
            ->get();
    }
    public function render()
    {
        $items = array();
        $paiments=Paiment::select('paiments.*','cost_generals.*')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                    ->where('cost_generals.type_other_cost_id',6)
                    ->where('cost_generals.id',$this->cost_id)
                    ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                    ->get();

            foreach ($paiments as $paiment) {
                $items[] = $paiment->student_id;
            }
            $this->paiments=$items;

        $inscriptions=Inscription::join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$this->classe_id)
                        ->where('scolary_year_id', $this->defaultScolaryYer->id)
                        ->orderBy('students.name','ASC')
                        ->whereNotIn('student_id',$items)
                        ->get();
        return view('livewire.control.not-frais-etat-control',['inscriptions'=>$inscriptions]);
    }
}
