<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\ClasseOption;
use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\Section;
use App\Models\TypeOtherCost;
use Livewire\Component;

class RapportAnnuelPage extends Component
{
    public $costs, $options, $scolaryyears, $costData;
    public $defaultScolaryYer, $cost_id = 0, $section_id = 0, $type_id = 0, $option_id=0;
    public $typeCosts = [], $optiosList = [];

    public function updatedTypeId($val)
    {
        $this->type_id = $val;
    }

    public function updatedSectionId($val)
    {
        $this->section_id = $val;
    }

    public function updatedOptionId($val)
    {
        $this->option_id = $val;
    }

    public function mount()
    {
        $this->defaultScolaryYer = ScolaryYear::where('active', true)->first();
        $this->costs = CostGeneral::where('type_other_cost_id', 6)->get();
        $this->options = Section::orderBy('name', 'ASC')
            ->get();
        $this->typeCosts = TypeOtherCost::all();

    }


    public function render()
    {
        $this->optiosList = ClasseOption::where('section_id', $this->section_id)->get();
        if ($this->option_id == 0) {
            $paiments = Paiment::select('paiments.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', $this->type_id)
                ->where('sections.id', $this->section_id)
                ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->orderBy('classes.name', 'ASC')
                ->get();
        } else {
            $paiments = Paiment::select('paiments.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', $this->type_id)
                ->where('sections.id', $this->section_id)
                ->where('classe_options.id', $this->option_id)
                ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->orderBy('classes.name', 'ASC')
                ->get();
        }

        return view('livewire.paiment.rapport.rapport-annuel-page', ['paiments' => $paiments]);
    }
}
