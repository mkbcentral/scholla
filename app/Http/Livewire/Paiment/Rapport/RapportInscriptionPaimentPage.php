<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use Carbon\Carbon;
use Livewire\Component;

class RapportInscriptionPaimentPage extends Component
{
    public $month,$months=[],$currentMonth;
    public $taux=2000,$periode;
    public $itemsPeriodeFilter=['Semain en cours','Semaine passée','Cette année'];
    public  $isMonthSorted=true,$itmePeriodSorted=0;
    public $date_to_search;
    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;

        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function refreshData(){
        $this->mounth=date('y-m-d');
    }
    public function render()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($this->periode=="Semain en cours") {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=1;
            $depot=0;
        } elseif($this->periode=="Semaine passée") {
            $date=Carbon::now()->subDays(7);
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->where('inscriptions.created_at', '>=', $date)
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
            $this->isMonthSorted=false;
            $this->itmePeriodSorted=2;
            $depot=0;
        }
        elseif($this->periode=="Cette année") {
                $date=Carbon::now()->subDays(7);
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereYear('inscriptions.created_at',Carbon::now())
                ->orderBy('inscriptions.created_at','DESC')
                ->where('inscriptions.is_paied',true)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                $this->isMonthSorted=false;
                $this->itmePeriodSorted=3;
                $depot=0;
        }else{
            $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->where('scolary_year_id',$this->defaultScolaryYer->id)
                    ->whereMonth('inscriptions.created_at',$this->month)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.is_paied',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            $this->isMonthSorted=true;
            $depot=DepotBank::whereMonth('created_at',$this->month)->sum('amount');
        }
        return view('livewire.paiment.rapport.rapport-inscription-paiment-page',
                ['inscriptions'=>$inscriptions,'depot'=>$depot]);
    }
}
