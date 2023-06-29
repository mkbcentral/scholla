<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\Section;
use App\Models\SortieFraisEtat;
use Livewire\Component;

class FraisEtatGlobalPage extends Component
{
    public $defaultScolaryYer,$date_to_search=null;
    public $amount_sortie,$executed_at;
    public $total_sortie=0;
    public $month,$months=[],$currentMonth;
    public $section_id=0;

    public $sections=[];

    public function mount()
    {
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->sections=Section::all();
    }
    public function executeSortie(){
        $this->validate([
            'amount_sortie'=>['required','numeric'],
            'executed_at'=>['required','date']
        ]);
        SortieFraisEtat::create([
            'amount'=>$this->amount_sortie,
            'executed_at'=>$this->executed_at,
        ]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Sortie bien réalisé !"]);
    }

    public function render()
    {
        if($this->date_to_search == null){
            $sorties=SortieFraisEtat::all();
            foreach ($sorties as $sortie) {
               $this->total_sortie+=$sortie->amount;
            }
        }else{
            $sortie=SortieFraisEtat::where('executed_at',$this->date_to_search)->first();
            if($sortie){
                $this->total_sortie=$sortie->amount;
            }else{
                $this->total_sortie=0;
            }

        }
        $paiments=Paiment::select('paiments.*')
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->join('classes','classes.id','=','paiments.classe_id')
            ->join('classe_options','classe_options.id','=','classes.classe_option_id')
            ->join('sections','sections.id','=','classe_options.section_id')
            ->where('cost_generals.type_other_cost_id',6)
            ->where('paiments.mounth_name',$this->month)
            ->where('sections.id',$this->section_id)
            ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        return view('livewire.paiment.rapport.frais-etat-global-page',['paiments'=>$paiments]);
    }
}
