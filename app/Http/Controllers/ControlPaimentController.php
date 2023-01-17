<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\CostGeneral;
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
            $days_arrys=array();
            for ($i=1; $i <= $days_numbers; $i++) {
                if ($i>= 25) {
                    $days_arrys[$i]=$i;
                }
            }
            $paiments=Paiment::select('paiments.*','cost_generals.*')
                        ->where('paiments.mounth_name', $month)
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                        ->where('cost_generals.type_other_cost_id',$costId)
                        ->where('paiments.scolary_year_id', $scolaryYearId)
                        ->get();
                $items=array();
                foreach ($paiments as $key => $paiment) {
                    $items[] = $paiment->student_id;
                }
                $inscriptions=Inscription::whereNotIn('student_id',$items)
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('scolary_year_id', $scolaryYearId)
                        ->orderBy('students.name','ASC')
                        //->whereIn(DB::raw("(DATE_FORMAT(created_at,'%d'))"), $days_arrys)
                        ->get();
                $scolaryYear=ScolaryYear::find($scolaryYearId);
                $classe=Classe::find($classeId);
                $cost=TypeOtherCost::find($costId);

                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('pages.control.prints.print-control-paiment',
                compact(['inscriptions','scolaryYear','classe','cost','month','days_arrys']));
                return $pdf->stream();
        }

        public function printControlIsPaiment($classeId,$costId,$month,$scolaryYearId){
            $days_numbers=$number = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            $days_arry=array();
            for ($i=1; $i <= $days_numbers; $i++) {
                if ($i>= 25) {
                    $days_arrys[$i]=$i;
                }
            }
            $paiments=Paiment::select('paiments.*','cost_generals.*')
                ->where('paiments.mounth_name', $month)

                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                ->where('cost_generals.type_other_cost_id',$costId)
                ->where('paiments.scolary_year_id', $scolaryYearId)
                ->get();
                foreach ($paiments as $key => $paiment) {
                    $items[] = $paiment->student_id;
                }
                $inscriptions=Inscription::whereIn('student_id',$items)
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('scolary_year_id', $scolaryYearId)
                        ->orderBy('students.name','ASC')
                        //->whereIn(DB::raw("(DATE_FORMAT(created_at,'%d'))"), $days_arrys)
                        ->get();
                $scolaryYear=ScolaryYear::find($scolaryYearId);
                $classe=Classe::find($classeId);
                $cost=TypeOtherCost::find($costId);

                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('pages.control.prints.print-is-paiment',
                compact(['inscriptions','scolaryYear','classe','cost','month']));
                return $pdf->stream();
        }

        public function printControlNotOtherPaiment($classeId,$costId,$scolaryYearId){
            $cost=CostGeneral::find($costId);
            $paiments=Paiment::select('paiments.*','cost_generals.*')

                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                ->where('paiments.cost_general_id',$costId)
                ->where('paiments.scolary_year_id', $scolaryYearId)
                ->get();
                foreach ($paiments as $key => $paiment) {
                    $items[] = $paiment->student_id;
                }
                $inscriptions=Inscription::whereNotIn('student_id',$items)
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('scolary_year_id', $scolaryYearId)
                        ->orderBy('students.name','ASC')
                        //->whereIn(DB::raw("(DATE_FORMAT(created_at,'%d'))"), $days_arrys)
                        ->get();
                $scolaryYear=ScolaryYear::find($scolaryYearId);
                $classe=Classe::find($classeId);
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('pages.control.prints.print-other-control-page',
                compact(['inscriptions','scolaryYear','classe','cost']));
                return $pdf->stream();
        }

        public function printControlIsOtherPaiment($classeId,$costId,$scolaryYearId){
            $cost=CostGeneral::find($costId);
            $paiments=Paiment::select('paiments.*','cost_generals.*')
                ->where('paiments.classe_id',$classeId)
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
                ->where('paiments.cost_general_id',$costId)
                ->where('paiments.scolary_year_id', $scolaryYearId)
                ->get();
                foreach ($paiments as $key => $paiment) {
                    $items[] = $paiment->student_id;
                }
                $inscriptions=Inscription::whereIn('student_id',$items)
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('scolary_year_id', $scolaryYearId)
                        ->orderBy('students.name','ASC')
                        //->whereIn(DB::raw("(DATE_FORMAT(created_at,'%d'))"), $days_arrys)
                        ->get();
                $scolaryYear=ScolaryYear::find($scolaryYearId);
                $classe=Classe::find($classeId);
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('pages.control.prints.print-is_other-control-page',
                compact(['inscriptions','scolaryYear','classe','cost']));
                return $pdf->stream();
        }

        public function printAllcontrol($classe_id,$type_id,$scolaryid){
            $inscriptions=Inscription::join('students','inscriptions.student_id','=','students.id')
            ->where('inscriptions.classe_id',$classe_id)
            ->where('scolary_year_id', $scolaryid)
                ->orderBy('students.name','ASC')
            ->get();

            $scolaryYear=ScolaryYear::find($scolaryid);
            $typeCost=TypeOtherCost::find($type_id);
            $classe=Classe::find($classe_id);

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pages.control.prints.print-all-control-paiement',
            compact(['inscriptions','scolaryYear','classe','typeCost','type_id']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapport.pdf');;
            return $pdf->stream();
        }



}
