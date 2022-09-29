<?php

namespace App\Http\Livewire\Requisition;

use App\Models\SourceReq;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class SourceDepensePage extends Component
{
    public $name,$solde,$isEditable=false,$sourceDeps,$sourceDepsToDelete;
    public $state =[];
    protected $listeners=['sourceDepsListener'=>'delete'];
    public $total_fonc=0;
    public $total_depense=0;

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'solde'=>'required|numeric'
            ]
        )->validate();
    }

    public function store(){
        $this->validateData();
        SourceReq::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Source dépense bien sauvegargée !"]);
    }

    public function edit(SourceReq $sourceDeps){
        $this->state=$sourceDeps->toArray();
        $this->isEditable=true;
        $this->sourceDeps=$sourceDeps;
    }

    public function update(){
        $this->validateData();
        $this->sourceDeps->name=$this->state['name'];
        $this->sourceDeps->solde=$this->state['solde'];
        $this->sourceDeps->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"sourceDeps bien mise à jour !"]);
    }

    public function showDeleteDialog(SourceReq $sourceDeps){
        $this->sourceDepsToDelete=$sourceDeps;
        $this->dispatchBrowserEvent('delete-sourceDeps-dialog');
    }

    public function delete(){
        $this->sourceDepsToDelete->delete();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"sourceDeps bien retirée !"]);
    }

    public function render()
    {
        $sources=SourceReq::orderBy('name','ASC')
                ->get();
        return view('livewire.requisition.source-depense-page',['sources'=>$sources]);
    }
}
