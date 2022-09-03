<?php

namespace App\Http\Livewire\Bank;

use App\Models\DepotBank;
use Livewire\Component;

class DepotBankPage extends Component
{
    public $title,$dateTo,$dateFrom,$amount,$observation,$devise,$labelTo,$labelFrom;
    public $depotToEdit,$depotToDelete,$currentMonth,$month,$months;
    protected $listeners=['depotListener'=>'delete'];

    public function store(){
        $this->validate([
            'title'=>'required',
            'dateTo'=>'date|required',
            'dateFrom'=>'date|required',
            'amount'=>'numeric',
            'devise'=>'required',
            'observation'=>'nullable',
        ]);

        $depot=new DepotBank();
        $depot->title=$this->title;
        $depot->dateTo=$this->dateTo;
        $depot->dateFrom=$this->dateFrom;
        $depot->amount=$this->amount;
        $depot->observation=$this->observation;
        $depot->observation=$this->observation;
        $depot->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Dépot bien ajouté!"]);
    }

    public function edit(DepotBank $depot){
        $this->title=$depot->title;
        $this->dateTo=$depot->dateTo;
        $this->dateFrom=$depot->dateFrom;
        $this->amount=$depot->amount;
        $this->devise=$depot->devise;
        $this->observation=$depot->observation;
        $this->depotToEdit=$depot;
        $this->labelTo=$this->dateTo->format('d/m/Y');
        $this->labelFrom=$this->dateFrom->format('d/m/Y');
    }
    public function update(){
        $this->validate([
            'title'=>'required',
            'dateTo'=>'date|required',
            'dateFrom'=>'date|required',
            'amount'=>'numeric',
            'devise'=>'required',
            'observation'=>'nullable',
        ]);
        $this->depotToEdit->title=$this->title;
        $this->depotToEdit->dateTo=$this->dateTo;
        $this->depotToEdit->dateFrom=$this->dateFrom;
        $this->depotToEdit->amount=$this->amount;
        $this->depotToEdit->devise=$this->devise;
        $this->depotToEdit->observation=$this->observation;
        $this->depotToEdit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Dépot bien ajouté!"]);
    }

    public function activeDepot(DepotBank $depot){
        if ($depot->active==true) {
            $depot->active=false;
        } else {
            $depot->active=true;
        }
        $depot->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Opération bien réalisée!"]);
    }

    public function showDeleteDialog(DepotBank $depot){
        $this->depotToDelete=$depot;
        $this->dispatchBrowserEvent('delete-depot-dialog');
    }

    public function delete(){
        if ($this->depotToDelete->active==true) {
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Impossible de retirer car ce depot est actif!"]);
        }else{
            $this->depotToDelete->delete();
            $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Dépot bank bien retirée !"]);
        }


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
        $depots=DepotBank::whereMonth('created_at',$this->month)->get();
        return view('livewire.bank.depot-bank-page',['depots'=>$depots]);
    }
}
