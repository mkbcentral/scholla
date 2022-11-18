<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Http\Livewire\Helpers\PaimentHelper;
use App\Models\Classe;
use App\Models\CostGeneral;
use App\Models\DepenseInPaiment;
use App\Models\PaieRegularisation;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Livewire\Component;

class RapportFraisByTypeGeneral extends Component
{
    public $type,$typeData,$typeFilters=['Tout','Dépot banque','Fonctionnement','Dépenses'];
    public $taux=2000,$costs=[],$cost_id=0,$defaultScolaryYer=0,$classes,$classe_id=0;

    public $dateTo="none",$dateFrom="none",$paiementDepanse,$paiementDepanseShow,$paiementRegularisation,
    $paiementRegularisationShow,$pai_amount,$mt=0;
    public $selectedRows=[],$selectPageRows=false,$isFilted=false,$scolaryyears,$scolary_id;

    public function updatedDateTo(){
        $this->isFilted=true;
    }

    public function updatedDateFrom(){
        $this->isFilted=true;
    }

    public function refreshData(){
        $this->isFilted=false;
    }

    public function updatedSelectPageRows($value){
        if ($value) {
           $this->selectedRows=$this->paiements->pluck('id')->map(function($id){
                return (string) $id;
           });
        }else{
            $this->reset(['selectedRows','selectPageRows']);
        }
    }

    public function edit(Paiment $paiment){
        $this->paiementDepanse =$paiment;
        $this->mt=$paiment->cost->amount;
        $this->paiementRegularisation=$paiment;
    }

    public function addDepense(){
        $depense=new DepenseInPaiment();
        $depense->amount=$this->pai_amount;
        $depense->paiment_id=$this->paiementDepanse->id;
        $depense->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Depense bien marquée !"]);
    }

    public function addRegularisation(){
        $depense=new PaieRegularisation();
        $depense->amount=$this->pai_amount;
        $depense->paiment_id=$this->paiementRegularisation->id;
        $depense->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Regularisation bien marquée !"]);
    }

    public function deleteDepense($id){
        $depense=DepenseInPaiment::where('paiment_id',$id)->first();
        $depense->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Depense bien annulée !"]);
    }

    public function deleteRegularisation($id){
        $depense=PaieRegularisation::where('paiment_id',$id)->first();
        $depense->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Régularisation bien annulée !"]);
    }

    public function show(Paiment $paiment){
        $this->paiementDepanseShow=$paiment;
    }

    public function getPaiementsProperty(){
        if ($this->isFilted==false) {
            $paiements=(new PaimentHelper())
                ->getPaimentYear($this->defaultScolaryYer->id,$this->cost_id,$this->classe_id,$this->type);
        } else {
            $paiements=(new PaimentHelper())
                ->getPaimentYearBetween($this->dateTo,$this->dateFrom,$this->defaultScolaryYer->id,$this->cost_id,$this->classe_id,$this->type);
        }
        return $paiements;
    }

    public function markIsBank(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_bank'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt banque"]);
    }

    public function markIsFonctionnement(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_fonctionnement'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué fonctionnment"]);
    }
    public function markIsDepense(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_depense'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt dépense"]);
    }

    public function markIsRegularisation(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_regularisation'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué rgularisation"]);
    }

    public function desableIsBank(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_bank'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt banque"]);
    }

    public function desableIsFonctionnement(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_fonctionnement'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué fonctionnment"]);
    }

    public function desableIsDepense(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_depense'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt dépense"]);
    }

    public function desableRegularisation(){
        Paiment::whereIn('id',$this->selectedRows)->update(['is_regularisation'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt dépense"]);
    }

    public function mount(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $this->costs=CostGeneral::orderBy('name','ASC')
                ->where('active',true)
                ->where('scolary_year_id', $this->defaultScolaryYer->id)
                ->where('type_other_cost_id',$this->type)
                ->get();
        $this->typeData=TypeOtherCost::find($this->type);
        $this->classes=Classe::orderBy('name','ASC')->with('option')->get();
        $this->scolaryyears=ScolaryYear::all();
    }

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }

    public function render()
    {
        $paiments=$this->paiements;
        return view('livewire.paiment.rapport.rapport-frais-by-type-general',['paiments'=>$paiments]);
    }
}
