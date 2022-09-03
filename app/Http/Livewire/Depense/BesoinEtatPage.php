<?php

namespace App\Http\Livewire\Depense;

use App\Models\EtatBesoin;
use Carbon\Carbon;
use Livewire\Component;

class BesoinEtatPage extends Component
{
    public $etatBesoin_sources=[];
    public $title,$amount,$description,$etatBesoin_souce_id,$emise_by,$etatBesoinToEdit;
    public $etatBesoinToTrashed;
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
        ]);
        $etatBesoin=new etatBesoin();
        $etatBesoin->title=$this->title;
        $etatBesoin->emise=$this->emise_by;
        $etatBesoin->amount=$this->amount;
        $etatBesoin->description=$this->description;
        $etatBesoin->user_id=auth()->user()->id;
        $etatBesoin->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Dépense bien sauvegardée !"]);
    }

    public function edit(EtatBesoin $etatBesoin){
        $this->title=$etatBesoin->title;
        $this->amount=$etatBesoin->amount;
        $this->description=$etatBesoin->description;
        $this->emise_by=$etatBesoin->emise;
        $this->etatBesoinToEdit=$etatBesoin;
    }
    public function showDeleteDialog(EtatBesoin $etatBesoin){
        $this->etatBesoinToTrashed=$etatBesoin;
        $this->dispatchBrowserEvent('delete-etatBesoin-dialog');
    }

    public function update(){
        $this->etatBesoinToEdit->title=$this->title;
        $this->etatBesoinToEdit->amount=$this->amount;
        $this->etatBesoinToEdit->description=$this->description;
        $this->etatBesoinToEdit->emise=$this->emise_by;
        $this->etatBesoinToEdit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépense bien mise à jour !"]);

    }
    public function activeetatBesoin(EtatBesoin $etatBesoin){
        if ($etatBesoin->active==false) {
           $etatBesoin->active=true;
        } else {
            $etatBesoin->active=false;
        }
        $etatBesoin->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépense bien mise à jour !"]);

    }
    public function delete(){
        if ($this->etatBesoinToTrashed->is_trashed==true) {
            $this->etatBesoinToTrashed->is_trashed=false;

        } else {
            $this->etatBesoinToTrashed->is_trashed=true;;
        }
        $this->etatBesoinToTrashed->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Dépense bien retirée !"]);

    }
    public function mount(){
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
            $etatBesoins=EtatBesoin::where('is_trashed',false)
                        ->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->get();
            $this->isMonthSorted=false;

            $this->itmePeriodSorted=1;

        } elseif($this->periode=="Semaine passée") {
            $date=Carbon::now()->subDays(7);
            $etatBesoins=EtatBesoin::where('is_trashed',false)
                        ->where('created_at', '>=', $date)
                        ->get();
            $this->isMonthSorted=false;

            $this->itmePeriodSorted=2;

        }else{
            if ($this->isMonthSorted==true) {
                $etatBesoins=EtatBesoin::where('is_trashed',false)
                        ->whereMonth('created_at',$this->month)
                        ->get();
            } else {
                $etatBesoins=EtatBesoin::where('is_trashed',false)
                ->whereDate('created_at',$this->date_to_search)
                ->get();
                $this->isMonthSorted=false;
            }

        }
        return view('livewire.depense.besoin-etat-page',['etatBesoins'=>$etatBesoins]);
    }
}
