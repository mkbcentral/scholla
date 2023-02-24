<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Classe;
use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class ArchiveJuinPage extends Component
{
    public $costs,$classes,$scolaryyears,$costData;
    public $defaultScolaryYer,$cost_id=0,$classe_id=0;
    public $month,$months=[],$currentMonth;
    public function mount()
    {
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->costs=CostGeneral::whereIn('id',[37,38,39,40,41,42])
            ->get();
    }
    public function render()
    {
        $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('cost_generals.id',$this->cost_id)
            ->where('paiments.classe_id',$this->classe_id)
            ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
            ->where('paiments.mounth_name',$this->month)
            ->get();
        return view('livewire.paiment.rapport.archive-juin-page',['paiments'=>$paiments]);
    }
}
