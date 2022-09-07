<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Carbon\Carbon;
use Livewire\Component;

class RapportBusPage extends Component
{
    public $month,$months=[],$currentMonth;
    public $taux=2000,$periode;
    public $itemsPeriodeFilter=['Semain en cours','Semaine passée'];
    public  $isMonthSorted=true,$itmePeriodSorted=0,$isDaySorted=false;
    public $costs=[],$cost_id=0,$date_to_search='',$paiment_date;
    public $paiment;


    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;

        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->costs=CostGeneral::orderBy('name','ASC')
            ->where('active',true)
            ->whereIn('id',[8,10,13,14])
            ->get();
    }

    public function edit(Paiment $paiment){
        $this->paiment=$paiment;
    }

    public function update(){
        $this->validate(['paiment_date'=>'date|required']);
        $this->paiment->created_at=$this->paiment_date;
        $this->paiment->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Date du frais bien mise à jour !"]);
    }

    public function delete(Paiment $paiment){
        $paiment->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Paiement bien retiré !"]);
    }
    public function updatedDateToSearch(){
        $this->itmePeriodSorted=0;
        $this->isMonthSorted=false;
        $this->isDaySorted=true;
    }
    public function updatedMonth(){
        $this->itmePeriodSorted=0;
        $this->isMonthSorted=true;
        $this->isDaySorted=false;
    }



    public function refreshData(){
        $this->mounth=date('y-m-d');
    }
    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($this->periode=="Semain en cours") {
            $paiments=Paiment::select('students.*','paiments.*','cost_generals.*')
            ->join('students','paiments.student_id','=','students.id')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('paiments.created_at','DESC')
            ->whereIn('cost_generals.id',[8,10,13,14])
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=1;
        } elseif($this->periode=="Semaine passée") {
            $date=Carbon::now()->subDays(7);
            $paiments=Paiment::select('students.*','paiments.*')
            ->join('students','paiments.student_id','=','students.id')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->where('paiments.created_at', '>=', $date)
            ->orderBy('paiments.created_at','DESC')
            ->whereIn('cost_generals.id',[8,10,13,14])
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=2;
        }else{
            if ($this->isMonthSorted==true) {
                $paiments=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereMonth('paiments.created_at',$this->month)
                ->orderBy('paiments.created_at','DESC')
                ->whereIn('cost_generals.id',[8,10,13,14])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('scolary_year_id',$this->defaultScolaryYer->id)
                    ->whereDate('paiments.created_at',$this->date_to_search)
                    ->orderBy('paiments.created_at','DESC')
                    ->whereIn('cost_generals.id',[8,10,13,14])
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            }
        }
        return view('livewire.paiment.rapport.rapport-bus-page',['paiments'=>$paiments]);
    }
}
