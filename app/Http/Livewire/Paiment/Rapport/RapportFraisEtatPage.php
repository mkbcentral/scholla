<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Classe;
use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class RapportFraisEtatPage extends Component
{
    public $costs,$classes,$scolaryyears,$costData;
    public $defaultScolaryYer,$cost_id=0,$classe_id=0;

    public function mount()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->costs=CostGeneral::where('type_other_cost_id',6)->get();
        $this->classes=Classe::orderBy('name','ASC')
            ->with('option')
            ->get();
    }

    public function getCost(){
        $this->costData=CostGeneral::find($this->cost_id);
    }

    public function render()
    {
        $paiments=Paiment::select('paiments.*')
        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
        ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
        ->where('cost_generals.type_other_cost_id',6)
        ->where('cost_generals.id',$this->cost_id)
        ->where('paiments.classe_id',$this->classe_id)
        ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
        ->orderBy('paiments.created_at','DESC')
        ->get();
        return view('livewire.paiment.rapport.rapport-frais-etat-page',['paiments'=>$paiments]);
    }
}
