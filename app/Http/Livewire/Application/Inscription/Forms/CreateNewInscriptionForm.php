<?php

namespace App\Http\Livewire\Application\Inscription\Forms;

use App\Http\Requests\NewStudentRequest;
use App\Models\Classe;
use App\Models\CostInscription;
use App\Models\Inscription;
use App\Models\Student;
use Livewire\Component;

class CreateNewInscriptionForm extends Component
{
    protected $listeners = ['selectedClasseOption' => 'getOptionSelected'];
    public $costInscriptionList = [];
    public $selectedOption = 0;

    public $name, $date_of_birth, $gender, $classe_id, $cost_inscription_id;


    public function getOptionSelected($index)
    {
        $this->selectedOption = $index;
    }

    public function store()
    {
        $request = new NewStudentRequest();
        $data = $this->validate($request->rules());
        $studentChek = Student::where('name', $data['name'])->first();
        if ($studentChek) {
            $this->dispatchBrowserEvent('data-deleted', ['message' => "Désolé cet élève existe déjà !"]);
        } else {
            $student = Student::create([
                'name' => $data['name'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
            ]);
            Inscription::create([
                'scolary_year_id' => 1,
                'cost_inscription_id' => $data['cost_inscription_id'],
                'student_id' => $student->id,
                'classe_id' => $data['classe_id'],
                'school_id' => auth()->user()->school->id,
                'user_id' => auth()->user()->id
            ]);
            $this->dispatchBrowserEvent('data-added', ['message' => "Inscription bien sauvegargée !"]);
        }
    }

    public function mount()
    {
        $this->costInscriptionList = CostInscription::where('school_id', auth()->user()->school->id)
            ->orderBy('created_at', 'DESC')->get();
    }
    public function render()
    {
        $classeList = Classe::join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->join('schools', 'schools.id', '=', 'sections.school_id')
            ->where('sections.school_id', auth()->user()->school->id)
            ->where('classes.classe_option_id', $this->selectedOption)
            ->select('classes.*')
            ->get();
        return view('livewire.application.inscription.forms.create-new-inscription-form', ['classeList' => $classeList]);
    }
}
