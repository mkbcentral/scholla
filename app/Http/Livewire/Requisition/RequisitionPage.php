<?php

namespace App\Http\Livewire\Requisition;

use App\Models\DetailRequisition;
use App\Models\EmitReq;
use App\Models\Requisition;
use App\Models\SourceReq;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RequisitionPage extends Component
{
    public $source,$solde,$isEditable=false,$requisitiion,$requisitiionToDelete,$requisitiionToAdd,$requisitiionToShow;
    public $state =[],$emitters=[],$details=[],$sources=[];
    protected $listeners=['requisitiionListener'=>'delete'];
    public $description,$amount;
    public function validateData(){
        Validator::make(
            $this->state,
            [
                'emit_req_id'=>'required',
                'source_req_id'=>'required',
            ]
        )->validate();
    }

    public function store(){

        $randCode=date('d').'.'.date('m').'.'.date('Y').'.'.rand(100,999);

        $this->validateData();
        $requisitiion=new Requisition();
        $requisitiion->code=$randCode;
        $requisitiion->emit_req_id =$this->state['emit_req_id'];
        $requisitiion->user_id =auth()->user()->id;
        $requisitiion->save();

        $this->dispatchBrowserEvent('data-added',['message'=>"Source dépense bien sauvegargée !"]);
    }

    public function edit(Requisition $requisitiion){
        $this->state=$requisitiion->toArray();
        $this->isEditable=true;
        $this->requisitiion=$requisitiion;
        $this->requisitiionToAdd=$requisitiion;
        $this->isEditable=true;
    }

    public function update(){
        dd($this->state);
        $this->validateData();

        $this->requisitiion->emit_req_id=$this->state['emit_req_id'];
        if ($this->state['source_req_id']) {
            $this->requisitiion->source_req_id =$this->state['source_req_id'];
        }
        $this->requisitiion->update();
        $this->isEditable=false;
        $this->dispatchBrowserEvent('data-updated',['message'=>"requisitiion bien mise à jour !"]);
    }

    public function changeEditableState(){
        $this->isEditable=false;
    }

    public function showDeleteDialog(Requisition $requisitiion){
        $this->requisitiionToDelete=$requisitiion;
        $this->dispatchBrowserEvent('delete-requisitiion-dialog');
    }

    public function delete(){
        $this->requisitiionToDelete->delete();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"requisitiion bien retirée !"]);
    }

    public function addDetail(){
        $this->validate([
            'description'=>'required',
            'amount'=>'required|numeric',
        ]);
        $detail=new DetailRequisition();
        $detail->description=$this->description;
        $detail->amount=$this->amount;
        $detail->requisition_id =$this->requisitiionToAdd->id;
        $detail->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Details bien sauvegargés !"]);
    }

    public function showDetails(Requisition $requisitiion){
        $this->details=DetailRequisition::where('requisition_id',$requisitiion->id)->get();
        $this->requisitiionToShow=$requisitiion;
    }

    public function deleteDetail(DetailRequisition $detail,Requisition $requisitiion){
        $detail->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Détail bien retirée !"]);
        $this->showDetails($requisitiion);
    }

    public function mount(){
        $this->emitters=EmitReq::all();
        $this->sources=SourceReq::all();
    }
    public function render()
    {
        $requisitions=Requisition::orderBy('created_at','ASC')
                ->with('details')
                ->get();
        return view('livewire.requisition.requisition-page',['requisitions'=>$requisitions]);
    }
}
