<?php

namespace App\Http\Livewire\Application\Inscription\Forms;

use App\Models\Classe;
use App\Models\CostInscription;
use App\Models\Inscription;
use App\Models\Student;
use Livewire\Component;

class EditInscriptionForm extends Component
{
    protected $listeners = ['studentAndInscription' => 'getStudentAndInscription'];
    public  $student =null;
    public $costInscriptionList = [];
    public $selectedOption = 0;
    public $name, $date_of_birth, $gender, $classe_id, $cost_inscription_id;

    public function getStudentAndInscription(Student $student,$index){
        $this->student=$student;
        $this->selectedOption=$index;
    }

    public function mount()
    {
        $this->costInscriptionList = CostInscription::where('school_id', auth()->user()->school->id)
            ->orderBy('created_at', 'DESC')->get();
    }

    public function render()
    {
        $this->name=$this->student?->name;
        $this->date_of_birth=$this->student?->date_of_birth;
        $this->gender=$this->student?->gender;
        $this->classe_id=$this->student?->inscription->classe_id;
        $this->cost_inscription_id=$this->student?->inscription->cost_inscription_id;

        $classeList = Classe::join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
        ->join('sections', 'sections.id', '=', 'classe_options.section_id')
        ->join('schools', 'schools.id', '=', 'sections.school_id')
        ->where('sections.school_id', auth()->user()->school->id)
        ->where('classes.classe_option_id', $this->selectedOption)
        ->select('classes.*')
        ->get();

        return view('livewire.application.inscription.forms.edit-inscription-form',['classeList'=>$classeList]);
    }
}
