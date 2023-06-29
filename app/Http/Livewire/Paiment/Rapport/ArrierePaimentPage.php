<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Paiment;
use Livewire\Component;

class ArrierePaimentPage extends Component
{
    public $month, $months = [], $currentMonth;

    public function mount()
    {
        $this->currentMonth = date('m');
        $this->month = $this->currentMonth;
        foreach (range(1, 12) as $m) {
            $this->months[] = date('m', mktime(0, 0, 0, $m, 1));
        }
    }
    public function render()
    {
        $arrieres = Paiment::whereIn('mounth_name', ['09', '10', '11', '12', '01'])
            ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
            ->with(['student.classe.option', 'student.classe', 'student', 'cost', 'depense', 'regularisation'])
            ->whereNotIn('cost_generals.type_other_cost_id', [6])

            ->whereMonth('paiments.created_at', $this->month)->get();
        return view('livewire.paiment.rapport.arriere-paiment-page', ['arrieres' => $arrieres]);
    }
}
