<?php

namespace App\Http\Livewire\School;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ClassePage extends Component
{
    use WithPagination;
    public $name,$isEditable=false,$classe,
            $classeToDelete,$options,$option_id_serach=null;
    public $state =[];
    public $users=[];
    protected $listeners=['classeListener'=>'delete'];


    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'classe_option_id'=>'required|numeric',
            ]
        )->validate();
    }

    public function store(){
        $this->validateData();
        Classe::create($this->state);
        $this->dispatchBrowserEvent('data-added',['message'=>"Option bien sauvegargée !"]);
    }

    public function edit(Classe $classe){
        $this->state=$classe->toArray();
        $this->isEditable=true;
        $this->classe=$classe;
    }

    public function update(){
        $this->validateData();
        $this->classe->name=$this->state['name'];
        $this->classe->classe_option_id=$this->state['classe_option_id'];
        $this->classe->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"classe bien mise à jour !"]);
    }

    public function showDeleteDialog(Classe $classe){
        $this->classeToDelete=$classe;
        $this->dispatchBrowserEvent('delete-classe-dialog');
    }

    public function delete(){
        if ($this->classeToDelete->students->isEmpty()) {
            $this->classeToDelete->delete();
            $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Classe bien retirée !"]);
        } else {
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Impossible de supprimer car laclasse a déjà des clasesse !"]);
        }


    }
    public function mount(){
        $this->options=ClasseOption::orderBy('name','ASC')->get();
        $role=Role::where('name','Titulaire')->first();
        $this->users=$role->users;
    }
    public function render()
    {
        if ($this->option_id_serach==null) {
            $classes=Classe::orderBy('name','ASC')
                ->paginate(4);
        } else {
            $classes=Classe::orderBy('name','ASC')
                ->where('classe_option_id',$this->option_id_serach)
                ->with('option')
                ->with('students')
                ->paginate(10);

        }
        return view('livewire.school.classe-page',['classes'=>$classes]);
    }
}
