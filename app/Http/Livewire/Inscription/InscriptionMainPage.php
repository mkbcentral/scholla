<?php

namespace App\Http\Livewire\Inscription;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostInscription;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\Student;
use App\Models\StudentResponsable;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class InscriptionMainPage extends Component
{
    public $selectedIndex=0;
    public $classes,$classe_id=0;
    public $keySearch='',$date_to_search;
    public $state=[],$studentToEdit,$studentToShow,$inscriptionToEdit;
    public $costs=[],$currenetDate;
    public $optionn,$optionns,$defaultScolaryYer;
    public $label_date='';
    public $classesToEdit;

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

        $this->options=ClasseOption::orderBy('name','ASC')->get();

        $this->classes=Classe::orderBy('name','ASC')
            ->where('classe_option_id',$this->selectedIndex)
            ->with('option')
            ->get();
    }
    public function changeIndex(ClasseOption $option){
        $this->selectedIndex=$option->id;
    }

    public function resetFeilds(){
        $this->state=[];
    }

    public function store(){

        Validator::make(
            $this->state,
            [
                'name'=>'required',
                'date_of_birth'=>'date|required',
                'gender'=>'required',
                'classe_id'=>'required',
                'cost_inscription_id'=>'required',
            ]
        )->validate();

        $studentChek=Student::where('name',$this->state['name'])->first();

        if ($studentChek) {
            if($studentChek->name== $this->state['name'] AND $studentChek->classe_id== $this->state['classe_id']){
                $this->dispatchBrowserEvent('data-deleted',['message'=>"Désolé cet élève existe déjà !"]);
            }else{
                $this->saveInfos();
            }
        }else{
            $this->saveInfos();
        }



    }

    public function edit(Student $student,Inscription $inscription){
        $this->state['name']=$student->name;
        $this->state['gender']=$student->gender;
        $this->state['date_of_birth']=$student->date_of_birth->format('d/m/Y');
        $this->state['place_of_birth']=$student->place_of_birth;
        $this->state['classe_id']=$student->classe_id;
        $this->state['cost_inscription_id']=$inscription->cost_inscription_id;

        $this->label_date= $this->state['date_of_birth'];

        $this->studentToEdit=$student;
        $this->inscriptionToEdit=$inscription;
        if($student->responsable!=null){
            $this->state['name_responsable']=$student->responsable->name;
            $this->state['phone']=$student->responsable->phone;
            $this->state['other_phone']=$student->responsable->other_phone;
            $this->state['email']=$student->responsable->email;
        }
    }

    public function editInfos(Student $student){
        $this->studentToShow=$student;
    }

    public function update(){
        Validator::make(
            $this->state,
            [
                'name_responsable'=>'required',
                'phone'=>'required',
                'other_phone'=>'nullable',
                'email'=>'nullable',
                'place_of_birth'=>'required',
                'name'=>'required',
                'date_of_birth'=>'date|required',
                'gender'=>'required',
                'classe_id'=>'required',
                'cost_inscription_id'=>'required',
            ]
        )->validate();
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

    public function saveInfos(){
        $student=new Student();
            $student->name=$this->state['name'];
            $student->gender=$this->state['gender'];
            $student->date_of_birth=$this->state['date_of_birth'];
            $student->classe_id=$this->state['classe_id'];
            $student->student_responsable_id=null;
            $student->save();

            $inscription=new Inscription();
            $inscription->scolary_year_id=$this->defaultScolaryYer->id;
            $inscription->cost_inscription_id=$this->state['cost_inscription_id'];;
            $inscription->number_paiment=$this->generateNumberPaiement();
            $inscription->student_id=$student->id;
            $inscription->classe_id=$this->state['classe_id'];
            $inscription->user_id=auth()->user()->id;
            $inscription->save();
            $this->dispatchBrowserEvent('data-added',['message'=>"Inscription bien sauvegargée !"]);
    }

    public function render()
    {

        $this->defaultScolaryYer=ScolaryYear::where('active',true)->first();
            $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$this->classe_id)
                        ->where('scolary_year_id',$this->defaultScolaryYer->id)
                        ->where('students.name','Like','%'.$this->keySearch.'%')
                        ->whereDate('inscriptions.created_at',$this->date_to_search)
                        ->orderBy('students.name','ASC')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();

        return view('livewire.inscription.inscription-main-page',
                ['inscriptions'=>$inscriptions]);
    }
}
