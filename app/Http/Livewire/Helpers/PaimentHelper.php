<?php
namespace  App\Http\Livewire\Helpers;
use App\Models\Paiment;
use Carbon\Carbon;

class PaimentHelper{
    //GET PAIMENT OF DAY
    public function getDatePaiments($date,$idSColaryYear,$idCost,$type,$classeId){
       if ($classeId==0) {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereDate('paiments.created_at',$date)
                ->where('cost_generals.type_other_cost_id',$type)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
                //dd($date);
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereDate('paiments.created_at',$date)
                ->where('cost_general_id',$idCost)
                ->where('cost_generals.type_other_cost_id',$type)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
       } else {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereDate('paiments.created_at',$date)
                ->where('cost_generals.type_other_cost_id',$type)
                ->where('paiments.classe_id',$classeId)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereDate('paiments.created_at',$date)
                ->where('cost_general_id',$idCost)
                ->where('cost_generals.type_other_cost_id',$type)
                ->where('paiments.classe_id',$classeId)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
       }
        return $paiements;
    }
    //GET PAIEMENT MONTH
    public function getMonthPaiments($month,$idSColaryYear,$idCost,$type,$classeId){
        if ($classeId==0) {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('paiments.mounth_name',$month)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->orderBy('paiments.created_at','DESC')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('paiments.mounth_name',$month)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('cost_general_id',$idCost)
                        ->orderBy('paiments.created_at','DESC')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        } else {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('paiments.mounth_name',$month)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('paiments.classe_id',$classeId)
                        ->orderBy('paiments.created_at','DESC')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiments=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('paiments.mounth_name',$month)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('cost_general_id',$idCost)
                        ->where('paiments.classe_id',$classeId)
                        ->orderBy('paiments.created_at','DESC')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        }
        return $paiments;
    }
     //GET PAIMENT CURRENT WEEK
     public function getCureentWeekPaiement($idSColaryYear,$idCost,$type,$classeId){
        if ($classeId) {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
            $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$idCost)
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        } else {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->where('paiments.classe_id',$classeId)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
            $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->whereBetween('paiments.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$idCost)
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->where('paiments.classe_id',$classeId)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        }
       return $paiments;
    }
    //GET PAIMENT WEEK
    public function getPassWeekPaiement($idSColaryYear,$idCost,$type,$classeId){
        $date=Carbon::now()->subDays(7);
        if ($classeId==0) {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->where('paiments.created_at', '>=', $date)
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
            $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->where('paiments.created_at', '>=', $date)
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$idCost)
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        } else {
            if ($idCost==0) {
                $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->where('paiments.created_at', '>=', $date)
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->where('paiments.classe_id',$classeId)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
            $paiments=Paiment::select('students.*','paiments.*')
                    ->join('students','paiments.student_id','=','students.id')
                    ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                    ->where('paiments.scolary_year_id',$idSColaryYear)
                    ->where('paiments.created_at', '>=', $date)
                    ->orderBy('paiments.created_at','DESC')
                    ->where('cost_general_id',$idCost)
                    ->where('cost_generals.type_other_cost_id',$type)
                    ->where('paiments.classe_id',$classeId)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        }
       return $paiments;
    }
    //GET BETWEEN 2 DATES
    public function getBetweenDatePaiements($dateTo,$dateFrom,$idSColaryYear,$idCost,$type,$classeId){
        if ($$classeId==0) {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                ->where('cost_generals.type_other_cost_id',$type)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                ->where('cost_general_id',$idCost)
                ->where('cost_generals.type_other_cost_id',$type)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
        } else {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                ->where('cost_generals.type_other_cost_id',$type)
                ->where('paiments.classe_id',$classeId)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                ->join('students','paiments.student_id','=','students.id')
                ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                ->where('cost_general_id',$idCost)
                ->where('paiments.classe_id',$classeId)
                ->where('cost_generals.type_other_cost_id',$type)
                ->orderBy('paiments.created_at','DESC')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }
        }
        return $paiements;
    }
    //GET PAIMENT YEAR
    public function getPaimentYear($idSColaryYear,$idCost,$classeId,$type){
        if ($classeId==0) {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('cost_general_id',$idCost)
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        } else {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('paiments.classe_id',$classeId)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('cost_general_id',$idCost)
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('paiments.classe_id',$classeId)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        }
        return $paiements;
    }
    //GET PAIMENT YEAR
    public function getPaimentYearBetween($dateTo,$dateFrom,$idSColaryYear,$idCost,$classeId,$type){
        if ($classeId==0) {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('cost_general_id',$idCost)
                        ->where('paiments.scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        } else {
            if ($idCost==0) {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('paiments.classe_id',$classeId)
                        ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $paiements=Paiment::select('students.*','paiments.*')
                        ->join('students','paiments.student_id','=','students.id')
                        ->join('cost_generals','cost_generals.id','=','paiments.cost_general_id')
                        ->orderBy('paiments.created_at','ASC')
                        ->where('cost_general_id',$idCost)
                        ->where('scolary_year_id',$idSColaryYear)
                        ->where('cost_generals.type_other_cost_id',$type)
                        ->where('paiments.classe_id',$classeId)
                        ->whereBetween('paiments.created_at',[$dateTo,$dateFrom])
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        }
        return $paiements;
    }
}
