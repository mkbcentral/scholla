<?php

namespace App\Http\Livewire\Cost;

use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TypeOtherCostPage extends Component
{
    public $name,$isEditable=false,$type,$typeToDelete,$defaultScolaryYer;
    public $state =[],$scolaryyears,$scolary_id;
    protected $listeners=['typeOtherListener'=>'delete'];

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

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
        $type=TypeOtherCost::create($this->state);
        $type->scolary_year_id=$this->defaultScolaryYer->id;
        $type->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Type bien sauvegargé !"]);
    }

    public function edit(TypeOtherCost $type){
        $this->state=$type->toArray();
        $this->isEditable=true;
        $this->typeToDelete=$type;
    }

    public function update(){
        $this->validateData();
        $this->typeToDelete->name=$this->state['name'];
        $this->typeToDelete->scolary_year_id=$this->defaultScolaryYer->id;
        $this->typeToDelete->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Type bien mis à jour !"]);
    }

    public function showDeleteDialog(TypeOtherCost $type){
        $this->typeToDelete=$type;
        $this->dispatchBrowserEvent('delete-type-other-dialog');
    }

    public function delete(){
        if($this->typeToDelete->active==false){
            $this->typeToDelete->active=true;
        }else{
            $this->typeToDelete->active=false;
        }
        $this->typeToDelete->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"scolaryYear bien retirée !"]);
    }

    public function mount(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->scolaryyears=ScolaryYear::all();
    }

    public function render()
    {
        $types=TypeOtherCost::orderBy('name','ASC')
                    ->where('scolary_year_id', $this->defaultScolaryYer->id)
                    ->get();
        return view('livewire.cost.type-other-cost-page',['types'=>$types]);
    }
}
