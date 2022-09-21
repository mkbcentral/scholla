<?php

namespace App\Http\Livewire\Widgets;

use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class NavOtherCost extends Component
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
                ->orderBy('name','ASC')->get();
        return view('livewire.widgets.nav-other-cost',['typeCosts'=>$typeCosts]);
    }
}
