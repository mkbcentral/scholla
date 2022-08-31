<?php

namespace App\Http\Livewire\Inscription;

use App\Models\Classe;
use App\Models\Section;
use Livewire\Component;

class InscriptionEvolutionPage extends Component
{
    public $selectedIndex=0;
    public $keySearch='';
    public function changeIndex($id){
        $this->selectedIndex=$id;
    }

    public function render()
    {
        if ($this->selectedIndex !=0) {
            $classes=Classe::select('classes.*')
            ->join('classe_options','classes.classe_option_id','=','classe_options.id')
            ->join('sections','classe_options.section_id','=','sections.id')
            ->where('sections.id',$this->selectedIndex)
            ->orderBy('classes.name','ASC')
            ->with('option')
            ->with('students')
            ->where('classes.name','Like','%'.$this->keySearch.'%')
            ->get();
        }else{
            $classes=[];
        }
        $sections=Section::all();
        return view('livewire.inscription.inscription-evolution-page',['sections'=>$sections,'classes'=>$classes]);
    }
}
