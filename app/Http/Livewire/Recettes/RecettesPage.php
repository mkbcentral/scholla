<?php

namespace App\Http\Livewire\Recettes;

use App\Models\AmoutPaie;
use App\Models\DepenseRecette;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class RecettesPage extends Component
{
    public $currentMonth,$month,$months,$month_name,$amount_salire,$amount_recette,$description_recette;
    public $scolaryyears,$scolary_id,$defaultScolaryYer,$paie=0;
    public function mount(){
        $this->scolaryyears=ScolaryYear::all();
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        //dd($this->defaultScolaryYer);
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }

        $salaire=AmoutPaie::where('month',$this->month)->whereYear('created_at',date('Y'))->first();
        if ($salaire) {
            $this->paie=$salaire->amount;
        } else {
            $this->paie=0;
        }

        //$arrieres=Paiment::whereIn('mounth_name',['09','10','11','12','01'])->whereDate('created')


    }
    public function addSalaire(){
        $this->validate([
            'amount_salire'=>'required|numeric',
            'month_name'=>'required'
        ]);

        $paie=AmoutPaie::where('month',$this->month_name)->whereYear('created_at',date('Y'))->first();
        if($paie){
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Ce mois est déjà programmé veillze choisir un autre mois SVP!"]);
        }else{
            AmoutPaie::create([
                'month'=>$this->month_name,
                'amount'=>$this->amount_salire,
            ]);
            $this->dispatchBrowserEvent('data-updated',['message'=>"Salaire bien fixé"]);
        }

    }

    public function addDepense(){
        $this->validate([
            'amount_recette'=>'required|numeric',
            'month_name'=>'required',
            'description_recette'=>'required'
        ]);
        DepenseRecette::create([
            'month'=>$this->month_name,
            'amount'=>$this->amount_recette,
            'description'=>$this->description_recette,
        ]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépense bien sajoutée"]);
    }
    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }
    public function render()
    {
        $costs=TypeOtherCost::with('costs')->get();
        $depenses=DepenseRecette::whereMonth('created_at',$this->month)->get();
        $inscription=Inscription::
        join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
            ->whereMonth('inscriptions.created_at',$this->month)
            ->where('inscriptions.is_paied',true)
            ->where('inscriptions.scolary_year_id',$this->defaultScolaryYer->id)
            ->sum('cost_inscriptions.amount');
        return view('livewire.recettes.recettes-page',['costs'=>$costs,'inscription'=>$inscription,'depenses'=>$depenses],);
    }
}
