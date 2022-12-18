<?php

namespace App\Http\Livewire\Recettes;

use App\Models\TypeOtherCost;
use Livewire\Component;

class RecettesPage extends Component
{
    public $costs;
    public $currentMonth,$month,$months;

    public function mount(){
        $this->costs=TypeOtherCost::all();
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function render()
    {
        return view('livewire.recettes.recettes-page');
    }
}
