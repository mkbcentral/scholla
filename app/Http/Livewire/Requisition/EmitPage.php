<?php

namespace App\Http\Livewire\Requisition;

use App\Models\EmitReq;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EmitPage extends Component
{
    public $name,$isEditable=false,$emitter,$emitterToDelete;
    public $state =[];
    protected $listeners=['emitterListener'=>'delete'];

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
            ]
        )->validate();
    }

    public function store(){
        $this->validateData();
        EmitReq::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"emitter bien sauvegargée !"]);
    }

    public function edit(EmitReq $emitter){
        $this->state=$emitter->toArray();
        $this->isEditable=true;
        $this->emitter=$emitter;
    }

    public function update(){
        $this->validateData();
        $this->emitter->name=$this->state['name'];
        $this->emitter->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"emitter bien mise à jour !"]);
    }

    public function showDeleteDialog(EmitReq $emitter){
        $this->emitterToDelete=$emitter;
        $this->dispatchBrowserEvent('delete-emitter-dialog');
    }

    public function delete(){
        $this->emitterToDelete->delete();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"emitter bien retirée !"]);
    }

    public function render()
    {
        $emitters=EmitReq::orderBy('name','ASC')
                ->get();
        return view('livewire.requisition.emit-page',['emitters'=>$emitters]);
    }
}
