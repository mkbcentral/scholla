<?php
namespace  App\Http\Livewire\Helpers;

use App\Models\Inscription;

class RapportInscriptionHepler{
    public function getPaiementsByType(){
        $inscriptions=Inscription::
        join('scolary_years','scolary_years.id','=','inscriptions.scolary_year_id')
        ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
        ->groupBy('cost_inscriptions.name')
        ->selectRaw('sum(cost_inscriptions.amount*2000) as total, cost_inscriptions.name')
        ->get();
        return $inscriptions;
    }
}
