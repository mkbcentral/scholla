<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Inscription;
use App\Models\Section;
use Livewire\Component;

class DashbaordSecretariat extends Component
{
    public $inscriptions=[],$newInsc=0,$oldInsc=0,
        $valuesTypesY=[],$valuesTypesX=[],
        $valuesInscData=[],
        $valuesInscLabel=['Inscription','Réinscription'];
    public function mount(){
        $this->inscriptions=Inscription::
            join('scolary_years','scolary_years.id','=','inscriptions.scolary_year_id')
            ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
            ->groupBy('cost_inscriptions.name')
            ->selectRaw('count(*) as total, cost_inscriptions.name')
            ->get();
        foreach ($this->inscriptions as $inscription) {
            if ($inscription->name=="Inscription" or $inscription->name=="Inscription 6ème secondaire") {
                $this->newInsc+=$inscription->total;
            }else{
                $this->oldInsc+=$inscription->total;
            }
            $this->valuesTypesY[]=$inscription->name;
            $this->valuesTypesX[]=$inscription->total;
        }
        $this->valuesInscData=[$this->newInsc,$this->oldInsc];
        //dd($this->valuesTypes);
    }
    public function render()
    {
        $sections=Section::all();
        return view('livewire.dashboard.dashbaord-secretariat',['sections'=>$sections]);
    }
}
