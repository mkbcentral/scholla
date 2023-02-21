<?php

namespace App\Http\Livewire\Widgets;

use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class NavOtherCostGeneral extends Component
{
    public $selectdIndex=0;
    public function changeIndex($id){
        $this->selectdIndex=$id;
    }
    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $typeCosts=TypeOtherCost::where('active',true)
                ->where('scolary_year_id', $this->defaultScolaryYer->id)
                ->whereNot('id',6)
                ->orderBy('name','ASC')->get();
        return view('livewire.widgets.nav-other-cost-general',['typeCosts'=>$typeCosts]);
    }
}
