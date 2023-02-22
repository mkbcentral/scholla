<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class RapportFraisEtatByDate extends Component
{
    public $defaultScolaryYer,$date_to_search=null;

    public function mount()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->date_to_search=date('Y-m-d');
    }

    public function render()
    {
        $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('cost_generals.type_other_cost_id',6)
            ->whereDate('paiments.created_at',$this->date_to_search)
            ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
            ->get();
        return view('livewire.paiment.rapport.rapport-frais-etat-by-date',['paiments'=>$paiments]);
    }
}
