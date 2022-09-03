<?php

namespace App\Http\Livewire\Depense;

use App\Models\Depense;
use App\Models\DepenseSouce;
use Carbon\Carbon;
use Livewire\Component;

class DepensePage extends Component
{
    public $depense_sources=[];
    public $title,$amount,$description,$depense_souce_id,$emise_by,$depenseToEdit;
    public $depenseToTrashed;
    public $month,$months=[],$currentMonth,$date_to_search='';
    public $taux=2000,$periode;
    public $itemsPeriodeFilter=['Semain en cours','Semaine passée'];
    public  $isMonthSorted=true,$itmePeriodSorted=0,$isDaySorted=false;

    protected $listeners=['depnseListener'=>'delete'];

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
    public function store(){
        $this->validate([
            'title'=>'required',
            'emise_by'=>'required',
            'amount'=>'required|numeric',
            'description'=>'required',
            'depense_souce_id'=>'required'
        ]);
        $depense=new Depense();
        $depense->title=$this->title;
        $depense->emise=$this->emise_by;
        $depense->amount=$this->amount;
        $depense->description=$this->description;
        $depense->depense_souce_id=$this->depense_souce_id;
        $depense->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Dépense bien sauvegardée !"]);
    }

    public function edit(Depense $depense){
        $this->title=$depense->title;
        $this->amount=$depense->amount;
        $this->description=$depense->description;
        $this->emise=$depense->emise_by;
        $this->depense_souce_id=$depense->depense_souce_id;
        $this->depenseToEdit=$depense;
    }
    public function showDeleteDialog(Depense $depense){
        $this->depenseToTrashed=$depense;
        $this->dispatchBrowserEvent('delete-depense-dialog');
    }

    public function update(){
        $this->depenseToEdit->title=$this->title;
        $this->depenseToEdit->amount=$this->amount;
        $this->depenseToEdit->description=$this->description;
        $this->depenseToEdit->emise=$this->emise_by;
        $this->depenseToEdit->depense_souce_id=$this->depense_souce_id;
        $this->depenseToEdit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépense bien mise à jour !"]);

    }
    public function activeDepense(Depense $depense){
        if ($depense->active==false) {
           $depense->active=true;
        } else {
            $depense->active=false;
        }
        $depense->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépense bien mise à jour !"]);

    }
    public function delete(){
        if ($this->depenseToTrashed->is_trashed==true) {
            $this->depenseToTrashed->is_trashed=false;

        } else {
            $this->depenseToTrashed->is_trashed=true;;
        }
        $this->depenseToTrashed->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Dépense bien retirée !"]);

    }
    public function mount(){
        $this->depense_sources=DepenseSouce::all();
        setlocale(LC_TIME, "fr_FR");
        $this->currentMonth=date('m');
        $this->month=$this->currentMonth;

        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function render()
    {
        if ($this->periode=="Semain en cours") {
            $depenses=Depense::where('is_trashed',false)
                        ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->get();
            $this->isMonthSorted=false;

            $this->itmePeriodSorted=1;

        } elseif($this->periode=="Semaine passée") {
            $date=Carbon::now()->subDays(7);
            $depenses=Depense::where('is_trashed',false)
                        ->where('created_at', '>=', $date)
                        ->get();
            $this->isMonthSorted=false;

            $this->itmePeriodSorted=2;

        }else{
            if ($this->isMonthSorted==true) {
                $depenses=Depense::where('is_trashed',false)
                        ->whereMonth('created_at',$this->month)
                        ->get();
            } else {
                $depenses=Depense::where('is_trashed',false)
                ->whereDate('created_at',$this->date_to_search)
                ->get();
                $this->isMonthSorted=false;
            }

        }
        return view('livewire.depense.depense-page',['depenses'=>$depenses]);
    }
}
