<?php

namespace App\Http\Livewire\Control;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class GeneralControl extends Component
{
    public $selectedIndex=0;
    public $classes,$classe_id=0,$cost_id=0,$scolaryyears,$scolary_id;
    public $keySearch='';
    public $state=[],$costs=[];
    public $defaultScolaryYer,$options=[];
    public $month_name,$months=[],$currentMonth,$inscription;
    public $paiments=[];
    public  $taux=2000;
    public $days=[];
    public $typeFrais=[],$type_id=0;

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function mount()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $defualtOption=ClasseOption::where('name','Primaire')->first();
        $this->selectedIndex=$defualtOption->id;
        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $this->scolaryyears=ScolaryYear::all();
        $this->typeFrais=TypeOtherCost::orderBy('name','ASC')->get();

        $this->classes=Classe::orderBy('name','ASC')
            ->with('option')
            ->get();
    }

    public function render()
    {
        $inscriptions=Inscription::join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$this->classe_id)
                        ->where('scolary_year_id', $this->defaultScolaryYer->id)
                            ->orderBy('students.name','ASC')
                        ->get();
        return view('livewire.control.general-control',['inscriptions'=>$inscriptions]);
    }
}
