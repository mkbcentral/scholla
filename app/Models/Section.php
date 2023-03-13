<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(ClasseOption::class);
    }

    public function getInscriptionCount($id)
    {
        $inscriptions = Student::select('students.id', 'inscriptions.')
            ->join('classes', 'students.classe_id', '=', 'classes.id')
            ->join('classe_options', 'classes.classe_option_id', '=', 'classe_options.id')
            ->join('sections', 'classe_options.section_id', '=', 'sections.id')
            ->where('sections.id', $id)
            ->with('option')
            ->with('classe')
            ->count();
        return $inscriptions;
    }

    public function getTotal($month, $id, $idSColaryYear)
    {
        $paiments = Paiment::join('cost_generals', 'paiments.cost_general_id', '=', 'cost_generals.id')
            ->join('type_other_costs', 'cost_generals.type_other_cost_id', '=', 'type_other_costs.id')
            ->join('classes', 'paiments.classe_id', '=', 'classes.id')
            ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->where('sections.id', $id)
            ->where('paiments.mounth_name', $month)
            ->where('paiments.scolary_year_id', $idSColaryYear)
            ->with(['cost'])
            ->get();
        $total = 0;
        foreach ($paiments as $paiment) {
            $amount = 0;
            if ($paiment->cost->id == 38) {
                $amount = ($paiment->cost->amount * 2000) - 8000;
            } elseif ($paiment->cost->id == 37) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 39) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 40) {
                $amount = ($paiment->cost->amount * 2000) - 12000;
            } elseif ($paiment->cost->id == 41) {
                $amount = ($paiment->cost->amount * 2000) - 16000;
            } elseif ($paiment->cost->id == 42) {
                $amount = ($paiment->cost->amount * 2000) - 18000;
            } else {
                $amount = $paiment->cost->amount * 2000;
            }
            $total += $amount;
        }

        return $total;
    }

    public function getTotalDate($date, $id, $idSColaryYear)
    {
        $paiments = Paiment::join('cost_generals', 'paiments.cost_general_id', '=', 'cost_generals.id')
            ->join('type_other_costs', 'cost_generals.type_other_cost_id', '=', 'type_other_costs.id')
            ->join('classes', 'paiments.classe_id', '=', 'classes.id')
            ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->where('sections.id', $id)
            ->whereDate('paiments.created_at', $date)
            ->where('paiments.scolary_year_id', $idSColaryYear)
            ->with(['cost'])
            ->get();
        $total = 0;
        foreach ($paiments as $paiment) {
            $amount = 0;
            if ($paiment->cost->id == 38) {
                $amount = ($paiment->cost->amount * 2000) - 8000;
            } elseif ($paiment->cost->id == 37) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 39) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 40) {
                $amount = ($paiment->cost->amount * 2000) - 12000;
            } elseif ($paiment->cost->id == 41) {
                $amount = ($paiment->cost->amount * 2000) - 16000;
            } elseif ($paiment->cost->id == 42) {
                $amount = ($paiment->cost->amount * 2000) - 18000;
            } else {
                $amount = $paiment->cost->amount * 2000;
            }
            $total += $amount;
        }

        return $total;
    }

    public function getTotalAll($id, $idSColaryYear)
    {
        $paiments = Paiment::join('cost_generals', 'paiments.cost_general_id', '=', 'cost_generals.id')
            ->join('type_other_costs', 'cost_generals.type_other_cost_id', '=', 'type_other_costs.id')
            ->join('classes', 'paiments.classe_id', '=', 'classes.id')
            ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->where('sections.id', $id)
            ->where('paiments.scolary_year_id', $idSColaryYear)
            ->with(['cost'])
            ->get();
        $total = 0;
        foreach ($paiments as $paiment) {
            $amount = 0;
            if ($paiment->cost->id == 38) {
                $amount = ($paiment->cost->amount * 2000) - 8000;
            } elseif ($paiment->cost->id == 37) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 39) {
                $amount = ($paiment->cost->amount * 2000) - 10000;
            } elseif ($paiment->cost->id == 40) {
                $amount = ($paiment->cost->amount * 2000) - 12000;
            } elseif ($paiment->cost->id == 41) {
                $amount = ($paiment->cost->amount * 2000) - 16000;
            } elseif ($paiment->cost->id == 42) {
                $amount = ($paiment->cost->amount * 2000) - 18000;
            } else {
                $amount = $paiment->cost->amount * 2000;
            }
            $total += $amount;
        }
        return $total;
    }
}
