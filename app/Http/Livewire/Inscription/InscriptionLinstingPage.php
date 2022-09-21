<?php

namespace App\Http\Livewire\Inscription;

use App\Http\Livewire\Helpers\InscriptionHelper;
use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostInscription;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\Student;
use App\Models\StudentResponsable;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class InscriptionLinstingPage extends Component
{
    public $selectedIndex=0;
    public $classes,$classe_id=0,$scolaryyears,$scolary_id;
    public $keySearch='',$date_to_search;
    public $state=[],$studentToEdit,$studentToShow,$inscriptionToEdit;
    public $costs=[],$currenetDate;
    public $optionn,$defaultScolaryYer,$options=[];
    public $label_date='';
    public $classesToEdit;
    public $studentToDelete,$inscriptionToActive,$inscriptionToDelete;
    protected $listeners=['deleteStudentListener'=>'deleteStudent','activeStudentListener'=>'activeStudent'];


    public function mount(){
        $defualtOption=ClasseOption::where('name','Primaire')->first();
        $this->selectedIndex=$defualtOption->id;
        $this->costs=CostInscription::orderBy('name','ASC')->where('active',true)->get();
        $this->option=$defualtOption;
        $this->currenetDate=date('y-m-d');
        $this->date_to_search=$this->currenetDate;
        $this->state['phone']=0;
        $this->state['other_phone']=0;
        $this->state['place_of_birth']="Auacun";
        $this->state['email']="Auacun";

        $this->classesToEdit=Classe::orderBy('name','ASC')->with('option')->get();
        $this->scolaryyears=ScolaryYear::all();
        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
    }

    public function changeScolaryid(){
        $this->defaultScolaryYer->id=$this->scolary_id;
    }


    public function changeIndex(ClasseOption $option){
        $this->selectedIndex=$option->id;

    }

    public function edit(Student $student,Inscription $inscription){

        $this->state['name']=$student->name;
        $this->state['gender']=$student->gender;
        $this->state['date_of_birth']=$student->date_of_birth->format('d/m/Y');
        $this->state['classe_id']=$student->classe_id;
        $this->state['cost_inscription_id']=$inscription->cost_inscription_id;
        $this->studentToEdit=$student;

        $this->label_date= $this->state['date_of_birth'];

        $this->inscriptionToEdit=$inscription;
        if($student->responsable!=null){
            $this->state['name_responsable']=$student->responsable->name;
            $this->state['phone']=$student->responsable->phone;
            $this->state['other_phone']=$student->responsable->other_phone;
            $this->state['email']=$student->responsable->email;
        }else{
            $this->state['phone']=0;
            $this->state['other_phone']=0;
            $this->state['email']="Auacun";
        }


    }

    public function editInfos(Student $student){
        $this->studentToShow=$student;
    }

    public function update(){
        $this->validateData();
        if( $this->studentToEdit->responsable==null){
            $resposabeleAdd=new StudentResponsable();
            $resposabeleAdd->name=$this->state['name_responsable'];
            $resposabeleAdd->phone=$this->state['phone'];
            $resposabeleAdd->other_phone=$this->state['other_phone'];
            $resposabeleAdd->email=$this->state['email'];
            $resposabeleAdd->save();
            $this->studentToEdit->student_responsable_id=$resposabeleAdd->id;
        }else{
            $this->studentToEdit->responsable->name=$this->state['name_responsable'];
            $this->studentToEdit->responsable->phone=$this->state['phone'];
            $this->studentToEdit->responsable->other_phone=$this->state['other_phone'];
            $this->studentToEdit->responsable->email=$this->state['email'];
            $this->studentToEdit->responsable->update();
            $this->studentToEdit->student_responsable_id=$this->studentToEdit->responsable->id;
        }
        $this->studentToEdit->name=$this->state['name'];
        $this->studentToEdit->gender=$this->state['gender'];
        $this->studentToEdit->date_of_birth=$this->state['date_of_birth'];
        $this->studentToEdit->place_of_birth=$this->state['place_of_birth'];
        $this->studentToEdit->classe_id=$this->state['classe_id'];
        //Update student infos
        $this->studentToEdit->update();
        $this->inscriptionToEdit->cost_inscription_id= $this->state['cost_inscription_id'];
        $this->inscriptionToEdit->classe_id= $this->state['classe_id'];
        //Update inscription info
        $this->inscriptionToEdit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Infos bien mise à jour !"]);
    }

    public function generateNumberPaiement(){
        $number=0;
        if($this->option->name=='Primaire'){
            $number=rand(99,1000).'-P';
        }else if($this->option->name=='Maternelle'){
            $number=rand(99,1000).'-M';
        }else{
            $number=rand(99,1000).'-S';
        }
        return $number;
    }

    public function validateData(){
        Validator::make(
            $this->state,
            [
                'name_responsable'=>'required',
                'phone'=>'nullable',
                'other_phone'=>'nullable',
                'email'=>'nullable',
                'place_of_birth'=>'nullable',
            ]
        )->validate();
    }

    public function showDeleteStudent(Inscription $inscription,Student $student){
        $this->studentToDelete=$student;
        $this->inscriptionToDelete=$inscription;
        $this->dispatchBrowserEvent('delete-student-dialog');
    }

    public function showActiveStudent(Inscription $inscription){
        $this->inscriptionToActive=$inscription;
        $this->dispatchBrowserEvent('active-student-dialog');
    }

    public function deleteStudent(){
        if ($this->inscriptionToDelete->is_paied==true) {
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Impossible supprimer, car l'élève a déjà paié l'inscription !"]);
        }else{
            $this->inscriptionToDelete->delete();
            $this->studentToDelete->delete();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Elève bien rétiré !"]);
        }


    }

    public function activeStudent(){
        $this->inscriptionToActive->active=false;
        $this->inscriptionToActive->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Elève marqué abondon !"]);
    }


    public function render()
    {
        $this->classes=Classe::orderBy('name','ASC')
            ->where('classe_option_id',$this->selectedIndex)
            ->with('option')
            ->get();
        $this->options=ClasseOption::orderBy('name','ASC')->get();
            $inscriptions=(new InscriptionHelper())->getByScolaryYearByClasse($this->defaultScolaryYer->id,$this->keySearch,$this->classe_id);
        return view('livewire.inscription.inscription-linsting-page',['inscriptions'=>$inscriptions]);
    }
}
