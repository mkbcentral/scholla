<?php

namespace App\Http\Livewire\Application\Inscription;

use App\Http\Livewire\Helpers\InscriptionHelper;
use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostInscription;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\Student;
use App\Models\StudentResponsable;
use Dotenv\Validator;
use Livewire\Component;

class NewInscription extends Component
{
    public $selectedIndex = 0;
    public $classes, $classe_id = 0;
    public $keySearch = '', $date_to_search;
    public $state = [], $studentToEdit, $studentToShow, $inscriptionToEdit;
    public $costs = [], $currenetDate;
    public  $optionList, $defaultScolaryYer;
    public $label_date = '';
    public $classesToEdit;

    public function shwoFormCreate()
    {
        $this->emit('selectedClasseOption', $this->selectedIndex);
    }

    public function mount()
    {
        $defualtOption = ClasseOption::where('name', 'Primaire')->first();
        $this->defaultScolaryYer = ScolaryYear::where('active', true)->first();
        $this->selectedIndex = $defualtOption->id;
        $this->currenetDate = date('y-m-d');
        $this->date_to_search = $this->currenetDate;
        $this->optionList = ClasseOption::orderBy('name', 'ASC')->get();
    }
    public function changeIndex(ClasseOption $option)
    {
        $this->selectedIndex = $option->id;
    }

    public function edit(Student $student)
    {
        $this->emit('studentAndInscription', $student,$this->selectedIndex);
    }

    public function editInfos(Student $student)
    {
        $this->studentToShow = $student;
    }
    public function render()
    {
        $this->classes = Classe::orderBy('name', 'ASC')
            ->where('classe_option_id', $this->selectedIndex)
            ->with('option')
            ->get();
        $inscriptions = (new InscriptionHelper())
            ->getDateInscriptions($this->date_to_search, $this->defaultScolaryYer->id, $this->classe_id, 0);
        return view('livewire.application.inscription.new-inscription', ['inscriptions' => $inscriptions]);
    }
}
