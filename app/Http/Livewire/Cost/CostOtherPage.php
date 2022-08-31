<?php

namespace App\Http\Livewire\Cost;

use App\Models\CostGeneral;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class CostOtherPage extends Component
{
    use WithPagination;
    public $name,$isEditable=false,$cost,$costToDelete;
    public $state =[];
    protected $listeners=['costOtherListener'=>'delete'];

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'amount'=>'required',
            ]
        )->validate();
    }

    public function resetFormState(){
        $this->isEditable=false;
        $this->state=[];
    }

    public function store(){
        $this->validateData();
        CostGeneral::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Frais bien sauvegargé !"]);
    }

    public function edit(CostGeneral $cost){
        $this->state=$cost->toArray();
        $this->isEditable=true;
        $this->costToDelete=$cost;
    }

    public function update(){
        $this->validateData();
        $this->costToDelete->name=$this->state['name'];
        $this->costToDelete->amount=$this->state['amount'];
        $this->costToDelete->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Frais bien mis à jour !"]);
    }

    public function showDeleteDialog(CostGeneral $cost){
        $this->costToDelete=$cost;
        $this->dispatchBrowserEvent('delete-cost-other-dialog');
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
        $costs=CostGeneral::orderBy('name','ASC')
                    ->where('active',true)
                    ->paginate(5);
        return view('livewire.cost.cost-other-page',['costs'=>$costs]);
    }
}
