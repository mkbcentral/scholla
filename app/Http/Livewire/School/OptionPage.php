<?php

namespace App\Http\Livewire\School;

use App\Models\ClasseOption;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class OptionPage extends Component
{
    use WithPagination;
    public $name,$isEditable=false,$option,
            $optionToDelete,$sections,$section_id_serach=0;
    public $state =[];
    protected $listeners=['optionListener'=>'delete'];

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'section_id'=>'required|numeric',
            ]
        )->validate();
    }

    public function store(){
        $this->validateData();
        ClasseOption::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Option bien sauvegargée !"]);
    }

    public function edit(ClasseOption $option){
        $this->state=$option->toArray();
        $this->isEditable=true;
        $this->option=$option;
    }

    public function update(){
        $this->validateData();
        $this->option->name=$this->state['name'];
        $this->option->section_id=$this->state['section_id'];
        $this->option->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Option bien mise à jour !"]);
    }

    public function showDeleteDialog(ClasseOption $option){
        $this->optionToDelete=$option;
        $this->dispatchBrowserEvent('delete-option-dialog');
    }

    public function delete(){
        if ($this->optionToDelete->classes->isEmpty()) {
            $this->optionToDelete->delete();
            $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Option bien retirée !"]);
        } else {
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Impossible de supprimer car l'option a déjà des clasesse !"]);
        }


    }
    public function mount(){
        $this->sections=Section::orderBy('name','ASC')->get();
    }
    public function render()
    {
        if ($this->section_id_serach==0) {
            $options=ClasseOption::orderBy('name','ASC')
            ->with('section')
            ->with('classes')
                ->paginate(4);
        } else {
            $options=ClasseOption::orderBy('name','ASC')
            ->where('section_id',$this->section_id_serach)
            ->with('section')
            ->with('classes')
            ->paginate(10);
        }
        return view('livewire.school.option-page',['options'=>$options]);
    }
}
