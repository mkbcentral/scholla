<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\DepenseInInscription;
use App\Models\DepotBank;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\Student;
use Livewire\Component;

class RapportInscriptionPaimentGlobalPage extends Component
{
    public $taux=2000,$isFilted=0;
    public $dateTo="none",$dateFrom="none",$keySearch='';
    public $selectedRows=[],$selectPageRows=false,$inscription,$inscriptionDepense,$inscriptionDepenseShow,
    $studentToDelete,$amount_depense,$insc_amount=0;
    protected $listeners=['deleteInscriptionListener'=>'delete'];

    public function updatedDateTo(){
        $this->isFilted=true;
    }

    public function updatedDateFrom(){
        $this->isFilted=true;
    }

    public function edit(Inscription $inscription){
        $this->inscriptionDepense=$inscription;
        $this->insc_amount=$inscription->cost->amount;
    }

    public function addDepense(){
        $depense=new DepenseInInscription();
        $depense->amount=$this->amount_depense;
        $depense->inscription_id=$this->inscriptionDepense->id;
        $depense->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Depense bien marquée !"]);
    }

    public function deleteDepense($id){
        $depense=DepenseInInscription::where('inscription_id',$id)->first();
        $depense->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Depense bien annulée !"]);
    }

    public function show(Inscription $inscription){
        $this->inscriptionDepenseShow=$inscription;
    }

    public function refreshData(){
        $this->isFilted=false;
    }

    public function updatedSelectPageRows($value){
        if ($value) {
           $this->selectedRows=$this->inscriptions->pluck('id')->map(function($id){
                return (string) $id;
           });
        }else{
            $this->reset(['selectedRows','selectPageRows']);
        }
    }

    public function showDeleteDialog(Inscription $inscription,Student $student){
        $this->inscription=$inscription;
        $this->studentToDelete=$student;
        $this->dispatchBrowserEvent('delete-inscription-dialog');
    }

    public function delete(){
        $this->inscription->delete();
        $this->studentToDelete->delete();
        $this->dispatchBrowserEvent('data-dialog-deleted',['message'=>"Inscription bien retirée !"]);
    }

    public function getInscriptionsProperty(){
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
        if ($this->isFilted==false) {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->where('students.name','Like','%'.$this->keySearch.'%')
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        } else {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
            ->join('students','inscriptions.student_id','=','students.id')
            ->where('scolary_year_id',$this->defaultScolaryYer->id)
            ->where('students.name','Like','%'.$this->keySearch.'%')
            ->orderBy('inscriptions.created_at','DESC')
            ->where('inscriptions.is_paied',true)
            ->whereBetween('inscriptions.created_at',[$this->dateTo,$this->dateFrom])
            ->with('cost')
            ->with('student')
            ->with('student.classe')
            ->with('student.classe.option')
            ->get();
        }
        return $inscriptions;
    }

    public function markIsBank(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_bank'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt banque"]);
    }

    public function markIsFonctionnement(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_fonctionnement'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué fonctionnment"]);
    }
    public function markIsDepense(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_depense'=>true]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt dépense"]);
    }

    public function desableIsBank(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_bank'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt banque"]);
    }

    public function desableIsFonctionnement(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_fonctionnement'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué fonctionnment"]);
    }
    public function desableIsDepense(){
        Inscription::whereIn('id',$this->selectedRows)->update(['is_depense'=>false]);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Paiement marqué dépôt dépense"]);
    }
    public function render()
    {

        $inscriptions=$this->inscriptions;

            $depot=DepotBank::sum('amount');
        return view('livewire.paiment.rapport.rapport-inscription-paiment-global-page',
            ['inscriptions'=>$inscriptions,'depot'=>$depot]);
    }
}
