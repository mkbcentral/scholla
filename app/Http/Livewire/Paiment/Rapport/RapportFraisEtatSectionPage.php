<?php

namespace App\Http\Livewire\Paiment\Rapport;

use App\Models\Classe;
use App\Models\ClasseOption;
use App\Models\CostGeneral;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\Section;
use Livewire\Component;

class RapportFraisEtatSectionPage extends Component
{
    public $costs, $options, $scolaryyears, $costData;
    public $defaultScolaryYer, $cost_id = 0, $section_id = 0;

    public function mount()
    {
        $this->defaultScolaryYer = ScolaryYear::where('active', true)->first();
        $this->costs = CostGeneral::where('type_other_cost_id', 6)->get();
        $this->options = Section::orderBy('name', 'ASC')
            ->get();
    }

    public function getCost()
    {
        $this->costData = CostGeneral::find($this->cost_id);
    }

    public function render()
    {
        if ($this->cost_id == 0) {
            $paiments = Paiment::select('paiments.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', 6)
                ->where('sections.id', $this->section_id)
                ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->orderBy('paiments.created_at','DESC')
                ->get();
        } else {
            $paiments = Paiment::select('paiments.*')
                ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
                ->join('type_other_costs', 'type_other_costs.id', '=', 'cost_generals.type_other_cost_id')
                ->join('classes', 'paiments.classe_id', '=', 'classes.id')
                ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
                ->join('sections', 'sections.id', '=', 'classe_options.section_id')
                ->where('cost_generals.type_other_cost_id', 6)
                ->where('paiments.cost_general_id', $this->cost_id)
                ->where('sections.id', $this->section_id)
                ->where('paiments.scolary_year_id', $this->defaultScolaryYer->id)
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->orderBy('paiments.created_at','DESC')
                ->get();
        }
        return view('livewire.paiment.rapport.rapport-frais-etat-section-page', ['paiments' => $paiments]);
    }
}
