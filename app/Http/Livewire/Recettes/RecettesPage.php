<?php

namespace App\Http\Livewire\Recettes;

use App\Models\Inscription;
use App\Models\TypeOtherCost;
use Livewire\Component;

class RecettesPage extends Component
{
    public $currentMonth,$month,$months;
    public function mount(){

        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }

    }
    public function render()
    {
        $costs=TypeOtherCost::all();
        $inscription=Inscription::
        join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
            ->whereMonth('inscriptions.created_at',$this->month)
            ->where('inscriptions.is_paied',true)
            ->sum('cost_inscriptions.amount');
        return view('livewire.recettes.recettes-page',['costs'=>$costs,'inscription'=>$inscription]);
    }
}
