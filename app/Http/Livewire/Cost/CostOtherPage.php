<?php

namespace App\Http\Livewire\Cost;

use App\Models\CostGeneral;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class CostOtherPage extends Component
{
    use WithPagination;
    public $name,$isEditable=false,$cost,$costToDelete,$types;
    public $state =[],$defaultScolaryYer,$scolaryyears,$scolary_id;
    protected $listeners=['costOtherListener'=>'delete'];

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'amount'=>'required',
                'type_other_cost_id'=>'nullable'
            ]
        )->validate();
    }

    public function resetFormState(){
        $this->isEditable=false;
        $this->state=[];
    }

    public function store(){
        $this->validateData();
        $cost=CostGeneral::create($this->state);
        $cost->scolary_year_id=$this->defaultScolaryYer->id;
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
        $this->costToDelete->type_other_cost_id=$this->state['type_other_cost_id'];
        $this->costToDelete->scolary_year_id=$this->defaultScolaryYer->id;
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

    public function mount(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->types=TypeOtherCost::orderBy('name','ASC')
                ->where('scolary_year_id', $this->defaultScolaryYer->id)
                ->get();
        $this->scolaryyears=ScolaryYear::all();
    }
    public function render()
    {
        $costs=CostGeneral::orderBy('name','ASC')
                    ->where('active',true)
                    ->where('scolary_year_id', $this->defaultScolaryYer->id)
                    ->paginate(5);
        return view('livewire.cost.cost-other-page',['costs'=>$costs]);
    }
}
