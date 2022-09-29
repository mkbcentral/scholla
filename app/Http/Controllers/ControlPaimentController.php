<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ControlPaimentController extends Controller
{
    public function printControlPaiment($classeId,$costId,$month,$scolaryYearId){
        $days_numbers=$number = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
        $days_arry=array();
        for ($i=1; $i <= $days_numbers; $i++) {
            if ($i>= 25) {
                $days_arrys[$i]=$i;
            }
        }
            $paiments=Paiment::select('paiments.*','cost_generals.*')
            ->whereMonth('paiments.created_at', $month)
            ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->where('cost_generals.type_other_cost_id',$costId)
            ->where('paiments.scolary_year_id', $scolaryYearId)
            ->get();
            foreach ($paiments as $key => $paiment) {
                $items[] = $paiment->student_id;
            }
            $inscriptions=Inscription::whereNotIn('student_id',$items)
                        ->where('classe_id',$classeId)
                        ->where('scolary_year_id', $scolaryYearId)
                        ->whereNotIn(DB::raw("(DATE_FORMAT(created_at,'%d'))"), $days_arrys)
                        ->get();
            $scolaryYear=ScolaryYear::find($scolaryYearId);
            $classe=Classe::find($classeId);
            $cost=TypeOtherCost::find($costId);

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.control.prints.print-control-paiment',
            compact(['inscriptions','scolaryYear','classe','cost','month']));
            return $pdf->stream();
    }



}
