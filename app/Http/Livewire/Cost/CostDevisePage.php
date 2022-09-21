<?php

namespace App\Http\Livewire\Cost;

use App\Models\Devise;
use App\Models\ScolaryYear;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CostDevisePage extends Component
{
    public $name,$isEditable=false,$devise,$deviseToData,$defaultScolaryYer;
    public $state =[],$scolaryyears,$scolary_id;
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
        $devise=Devise::create($this->state);
        $devise->scolary_year_id=$this->defaultScolaryYer->id;
        $devise->update();
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
        $this->deviseToData->scolary_year_id=$this->defaultScolaryYer->id;
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

    public function mount(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->scolaryyears=ScolaryYear::all();
    }

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function render()
    {
        $devises=Devise::orderBy('name','ASC')
                    ->where('scolary_year_id', $this->defaultScolaryYer->id)
                    ->get();
        return view('livewire.cost.cost-devise-page',['devises'=>$devises]);
    }
}
