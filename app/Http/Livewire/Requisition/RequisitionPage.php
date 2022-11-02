<?php

namespace App\Http\Livewire\Requisition;

use App\Models\DetailRequisition;
use App\Models\EmitReq;
use App\Models\Requisition;
use App\Models\ScolaryYear;
use App\Models\SourceReq;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RequisitionPage extends Component
{
    public $source,$solde,$isEditable=false,$requisitiion,$requisitiionToDelete,
        $requisitiionToAdd,$requisitiionToShow;
    public $state =[],$emitters=[],$details=[],$sources=[];
    protected $listeners=['requisitiionListener'=>'delete'];
    public $month,$months=[],$currentMonth,$date_to_search='0',$scolaryyears,$scolary_id,$defaultScolaryYer;
    public $description,$amount,$isDaySorted=false,$valuSorte=0;


    public function updatedDateToSearch(){
        $this->isDaySorted=true;
        $this->valuSorte=1;
    }

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

        //$this->validateData();
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
        $this->validateData();

        $randCode= (new DateTime($this->state['created_at']))->format('d').'.'.
                (new DateTime($this->state['created_at']))->format('m')
                .'.'.(new DateTime($this->state['created_at']))->format('Y')
                .'.'.rand(100,999);
        $this->requisitiion->code=$randCode;
        $this->requisitiion->emit_req_id=$this->state['emit_req_id'];
        $this->requisitiion->created_at=$this->state['created_at'];
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
        if ($this->requisitiionToDelete->details()) {
            foreach ($this->requisitiionToDelete->details() as  $detail) {
               $d=DetailRequisition::find($detail->id);
               $d->delete();
            }
            $this->requisitiionToDelete->delete();
        } else {
            $this->requisitiionToDelete->delete();
        }

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

    public function activeDetal(DetailRequisition $detail, Requisition $requisitiion){
        if ($detail->active==false) {
            $detail->active=true;
        } else {
            $detail->active=false;
        }
        $detail->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Action bien réalisée !"]);
        $this->showDetails($requisitiion);

    }

    public function activeRequisition(Requisition $requisitiion){
        if ($requisitiion->active==false) {
           $requisitiion->active=true;
        } else {
            $requisitiion->active=false;
        }
        $requisitiion->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Action bien réalisée !"]);

    }

    public function mount(){
        setlocale(LC_TIME, "fr_FR");
            $this->currentMonth=date('m');
            $this->month=$this->currentMonth;
            foreach (range(1,12) as $m) {
                $this->months[]=date('m',mktime(0,0,0,$m,1));
            }
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->emitters=EmitReq::all();
        $this->sources=SourceReq::all();
    }
    public function render()
    {
        if ($this->isDaySorted==false) {
            $requisitions=Requisition::orderBy('created_at','ASC')
            ->with('details')
            ->whereMonth('created_at',$this->month)
            ->get();
        } else {
            $requisitions=Requisition::orderBy('created_at','ASC')
            ->with('details')
            ->whereDate('created_at',$this->date_to_search)
            ->get();
        }
        return view('livewire.requisition.requisition-page',['requisitions'=>$requisitions]);
    }
}
