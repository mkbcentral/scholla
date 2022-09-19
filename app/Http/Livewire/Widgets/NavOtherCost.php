<?php

namespace App\Http\Livewire\Widgets;

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
        $typeCosts=TypeOtherCost::where('active',true)->orderBy('name','ASC')->get();
        return view('livewire.widgets.nav-other-cost',['typeCosts'=>$typeCosts]);
    }
}
