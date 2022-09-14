<?php

namespace App\Http\Livewire\School;

use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class SectionPage extends Component
{
    public $name,$isEditable=false,$section,$sectionToDelete;
    public $state =[];
    protected $listeners=['SectionListener'=>'delete'];

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
        Section::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Section bien sauvegargée !"]);
    }

    public function edit(Section $section){
        $this->state=$section->toArray();
        $this->isEditable=true;
        $this->section=$section;
    }

    public function update(){
        $this->validateData();
        $this->section->name=$this->state['name'];
        $this->section->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"Section bien mise à jour !"]);
    }

    public function showDeleteDialog(Section $section){
        $this->sectionToDelete=$section;
        $this->dispatchBrowserEvent('delete-section-dialog');
    }

    public function delete(){
        if ( $this->sectionToDelete->options->isempty()) {
            $this->sectionToDelete->delete();
            $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Section bien retirée !"]);
        } else {
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Impossible de supprimer car la section a déjà des option !"]);
        }

    }

    public function render()
    {
        $sections=Section::orderBy('name','ASC')
                ->with('options')
                ->get();
        return view('livewire.school.section-page',['sections'=>$sections]);
    }
}
