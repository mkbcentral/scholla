<?php

namespace App\Http\Livewire\Cost;

use App\Models\CostInscription;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CostInscriptionPage extends Component
{
    public $name,$isEditable=false,$cost,$costToDelete;
    public $state =[];
    protected $listeners=['costListener'=>'delete'];

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
            ]
        )->validate();
    }

    public function resetFormState(){
        $this->isEditable=false;
        $this->state=[];
    }

    public function store(){
        $this->validateData();
        CostInscription::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Frais bien sauvegargé !"]);
    }

    public function edit(CostInscription $cost){
        $this->state=$cost->toArray();
        $this->isEditable=true;
        $this->cost=$cost;
    }

    public function update(){
        $this->validateData();
        $this->cost->name=$this->state['name'];
        $this->cost->amount=$this->state['amount'];
        $this->cost->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Frais bien mis à jour !"]);
    }

    public function showDeleteDialog(CostInscription $cost){
        $this->costToDelete=$cost;
        $this->dispatchBrowserEvent('delete-cost-dialog');
    }

    public function delete(){
        if($this->costToDelete->active==false){
            $this->costToDelete->active=true;
        }else{
            $this->costToDelete->active=false;
        }
        $this->costToDelete->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"scolaryYear bien retirée !"]);
    }

    public function render()
    {
        $costs=CostInscription::orderBy('name','ASC')
                    ->where('active',true)
                    ->get();
        return view('livewire.cost.cost-inscription-page',['costs'=>$costs]);
    }
}
