<?php

namespace App\Http\Livewire\Cost;

use App\Models\CostInscription;
use App\Models\ScolaryYear;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CostInscriptionPage extends Component
{
    public $name,$isEditable=false,$cost,$costToDelete,$defaultScolaryYer;
    public $state =[],$scolaryyears,$scolary_id;
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
        $cost=CostInscription::create($this->state);
        $cost->scolary_year_id=$this->defaultScolaryYer->id;
        $cost->update();
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
        $this->cost->scolary_year_id=$this->defaultScolaryYer->id;
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

    public function mount(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->scolaryyears=ScolaryYear::all();
    }


    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function render()
    {
        $costs=CostInscription::orderBy('name','ASC')
                    ->where('active',true)
                    ->where('scolary_year_id', $this->defaultScolaryYer->id)
                    ->get();
        return view('livewire.cost.cost-inscription-page',['costs'=>$costs]);
    }
}
