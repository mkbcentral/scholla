<?php

namespace App\Http\Livewire\Control;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\Student;
use Livewire\Component;

class NotPaiementPage extends Component
{
    public $selectedIndex=0;
    public $classes,$classe_id=0,$cost_id=0;
    public $keySearch='';
    public $state=[],$costs=[];
    public $defaultScolaryYer,$options=[];
    public $month_name,$months=[],$currentMonth,$inscription;
    public $paiments=[];
    public  $taux=2000;

    public function mount()
    {
        $defualtOption=ClasseOption::where('name','Primaire')->first();
        $this->selectedIndex=$defualtOption->id;

        $this->option=$defualtOption;

        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }

    public function render()
    {
        $this->classes=Classe::orderBy('name','ASC')
            ->where('classe_option_id',$this->selectedIndex)
            ->with('option')
            ->get();
        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $students=Student::where('classe_id',$this->classe_id)
                            ->get();
        return view('livewire.control.not-paiement-page',['students'=>$students]);
    }
}
