<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use Livewire\Component;

class RapportBusGlobalPage extends Component
{
    public $taux=2000,$costs=[],$cost_id=0,$defaultScolaryYer;

    public $dateTo="none",$dateFrom="none";
    public $selectedRows=[],$selectPageRows=false,$isFilted=false;

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

    public function getPaiementsProperty(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($this->isFilted==false) {
            if ($this->cost_id==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->orderBy('paiments.created_at','ASC')
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereIn('cost_generals.id',[8,10,13])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->orderBy('paiments.created_at','ASC')
                ->where('cost_general_id',$this->cost_id)
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereIn('cost_generals.id',[8,10,13])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
        } else {
            if ($this->cost_id==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->orderBy('paiments.created_at','ASC')
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereBetween('paiments.created_at',[$this->dateTo,$this->dateFrom])
                ->whereIn('cost_generals.id',[8,10,13])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->orderBy('paiments.created_at','ASC')
                ->where('cost_general_id',$this->cost_id)
                ->where('scolary_year_id',$this->defaultScolaryYer->id)
                ->whereBetween('paiments.created_at',[$this->dateTo,$this->dateFrom])
                ->whereIn('cost_generals.id',[8,10,13])
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
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

    public function mount(){
        $this->costs=CostGeneral::orderBy('name','ASC')
                ->where('active',true)
                ->whereIn('id',[8,10,13])
                ->get();
    }

    public function render()
    {
        $paiments=$this->paiements;
        return view('livewire.paiment.rapport.rapport-bus-global-page',['paiments'=>$paiments]);
    }
}
