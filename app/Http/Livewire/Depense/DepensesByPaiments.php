<?php

namespace App\Http\Livewire\Depense;

use App\Models\Paiment;
use App\Models\TypeOtherCost;
use Livewire\Component;

class DepensesByPaiments extends Component
{
    public $type,$taux=2000;
    public $month,$months=[],$currentMonth,$date_to_search='';
    public  $isDaySorted=true;
    public $frais;

    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->frais=TypeOtherCost::find($this->type);
    }
    public function updatedDateToSearch(){
        $this->isDaySorted=true;
    }
    public function updatedMonth(){
        $this->isDaySorted=false;
    }
    public function render()
    {
        if ($this->isDaySorted==true) {
            $paiements=Paiment::select('students.*','paiments.*')
        ->join('students','paiments.student_id','=','students.id')
        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
        ->where('paiments.scolary_year_id',1)
        ->whereDate('paiments.created_at',$this->date_to_search)
        ->where('cost_generals.type_other_cost_id',$this->type)
        ->where('paiments.is_depense',true)
        ->orderBy('paiments.created_at','DESC')
        ->with('cost')
        ->with('student')
        ->with('student.classe')
        ->with('student.classe.option')
        ->get();
        }else{
            $paiements=Paiment::select('students.*','paiments.*')
            ->join('students','paiments.student_id','=','students.id')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->where('paiments.scolary_year_id',1)
            ->whereMonth('paiments.created_at',$this->month)
            ->where('cost_generals.type_other_cost_id',$this->type)
            ->where('paiments.is_depense',true)
            ->orderBy('paiments.created_at','DESC')
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        }
        return view('livewire.depense.depenses-by-paiments',['paiments'=>$paiements]);
    }
}
