<?php

namespace App\Http\Livewire\Cost;

use App\Models\Devise;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CostDevisePage extends Component
{
    public $name,$isEditable=false,$devise,$deviseToData;
    public $state =[];
    protected $listeners=['deviseOtherListener'=>'delete'];

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'taux'=>'required',
            ]
        )->validate();
    }

    public function store(){
        $this->validateData();
        Devise::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Devisen sauvegargé !"]);
    }

    public function edit(Devise $devise){
        $this->state=$devise->toArray();
        $this->isEditable=true;
        $this->deviseToData=$devise;
    }

    public function update(){
        $this->validateData();
        $this->deviseToData->name=$this->state['name'];
        $this->deviseToData->taux=$this->state['taux'];
        $this->deviseToData->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Devise mise à jour !"]);
    }

    public function showDeleteDialog(Devise $devise){
        $this->deviseToData=$devise;
        $this->dispatchBrowserEvent('delete-devise-dialog');
    }
    public function resetFormState(){
        $this->isEditable=false;
        $this->state=[];
    }

    public function delete(){
        if($this->deviseToData->active==false){
            $this->deviseToData->active=true;
        }else{
            $this->deviseToData->active=false;
        }
        $this->deviseToData->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Devise bien retirée !"]);
    }

    public function render()
    {
        $devises=Devise::orderBy('name','ASC')
                    ->get();
        return view('livewire.cost.cost-devise-page',['devises'=>$devises]);
    }
}
