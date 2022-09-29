<?php
namespace  App\Http\Livewire\Helpers;

use App\Models\Inscription;
use App\Models\Paiment;

class RapportPaimentHepler{
    public function getPaiementsByType(){
        $paiements=Paiment::join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                ->groupBy('type_other_costs.name')
                ->selectRaw('sum(cost_generals.amount*2000) as total, type_other_costs.name')
                ->where('paiments.scolary_year_id','1')
                ->get();
        return $paiements;
    }

}
