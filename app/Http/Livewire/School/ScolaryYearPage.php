<?php

namespace App\Http\Livewire\School;

use App\Models\ScolaryYear;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ScolaryYearPage extends Component
{
    public $name,$isEditable=false,$scolaryYear,$scolaryYearToEdit;
    public $state =[];
    protected $listeners=['scolaryYearListener'=>'delete'];

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
        ScolaryYear::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"scolaryYear bien sauvegargée !"]);
    }

    public function edit(ScolaryYear $scolaryYear){
        $this->state=$scolaryYear->toArray();
        $this->isEditable=true;
        $this->scolaryYear=$scolaryYear;
    }

    public function update(){
        $this->validateData();
        $this->scolaryYear->name=$this->state['name'];
        $this->scolaryYear->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Année scolaire bien mise à jour !"]);
    }

    public function showDeleteDialog(scolaryYear $scolaryYear){
        $this->scolaryYearToEdit=$scolaryYear;
        $this->dispatchBrowserEvent('delete-scolaryYear-dialog');
    }

    public function delete(){
        if($this->scolaryYearToEdit->active==false){
            $this->scolaryYearToEdit->active=true;
        }else{
            $this->scolaryYearToEdit->active=false;
        }
        $this->scolaryYearToEdit->update();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"scolaryYear bien retirée !"]);
    }

    public function render()
    {
        $scolaryYears=ScolaryYear::orderBy('name','ASC')->get();
        return view('livewire.school.scolary-year-page',['scolaryYears'=>$scolaryYears]);
    }
}
