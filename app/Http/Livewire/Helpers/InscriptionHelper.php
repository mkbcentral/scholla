<?php
namespace  App\Http\Livewire\Helpers;

use App\Models\Inscription;
use Carbon\Carbon;

class InscriptionHelper{
    //GET DATE INSCRIPTIONS
    public function getDateInscriptions($date,$scolaryYearId,$classeId,$costId){
        if ($classeId==0) {
           if ($costId==0) {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereDate('inscriptions.created_at',$date)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereDate('inscriptions.created_at',$date)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }

        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereDate('inscriptions.created_at',$date)
                    ->where('inscriptions.classe_id',$classeId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereDate('inscriptions.created_at',$date)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            }

        }
        return $inscriptions;
    }
    //GET MONTH INSCRIPTIONS
    public function getMonthInscriptions($month,$scolaryYearId,$classeId,$costId,$keySearch){
        if ($classeId==0) {
           if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereMonth('inscriptions.created_at',$month)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereMonth('inscriptions.created_at',$month)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                        ->where('inscriptions.scolary_year_id',$scolaryYearId)
                        ->whereMonth('inscriptions.created_at',$month)
                        ->where('inscriptions.classe_id',$classeId)
                        ->orderBy('inscriptions.created_at','DESC')
                        ->where('inscriptions.active',true)
                        ->where('inscriptions.is_paied',true)
                        ->where('students.name','Like','%'.$keySearch.'%')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                        ->where('inscriptions.scolary_year_id',$scolaryYearId)
                        ->whereMonth('inscriptions.created_at',$month)
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('inscriptions.cost_inscription_id',$costId)
                        ->where('students.name','Like','%'.$keySearch.'%')
                        ->orderBy('inscriptions.created_at','DESC')
                        ->where('inscriptions.active',true)
                        ->where('inscriptions.is_paied',true)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        }
        return $inscriptions;
    }
    //GET CURRENT WEEK INSCRIPTIONS
    public function getCurrentWeekInscriptions($scolaryYearId,$classeId,$costId,$keySearch){
        if ($classeId==0) {
           if ($costId==0) {
            $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }
        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                ->where('inscriptions.scolary_year_id',$scolaryYearId)
                ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('inscriptions.classe_id',$classeId)
                ->orderBy('inscriptions.created_at','DESC')
                ->where('inscriptions.active',true)
                ->where('inscriptions.is_paied',true)
                ->where('students.name','Like','%'.$keySearch.'%')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                ->where('inscriptions.scolary_year_id',$scolaryYearId)
                ->whereBetween('inscriptions.created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('inscriptions.classe_id',$classeId)
                ->where('inscriptions.cost_inscription_id',$costId)
                ->where('inscriptions.classe_id',$classeId)
                ->orderBy('inscriptions.created_at','DESC')
                ->where('inscriptions.active',true)
                ->where('inscriptions.is_paied',true)
                ->where('students.name','Like','%'.$keySearch.'%')
                ->with('cost')
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
            }

        }
        return $inscriptions;
    }
    //GET LAST WEEK INSCRIPTIONS
    public function getPassWeekInscriptions($scolaryYearId,$classeId,$costId,$keySearch){
        $date=Carbon::now()->subDays(7);
        if ($classeId==0) {
           if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                     ->where('inscriptions.created_at', '>=', $date)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.created_at', '>=', $date)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }

        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.created_at', '>=', $date)
                    ->where('inscriptions.classe_id',$classeId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.created_at', '>=', $date)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            }

        }
        return $inscriptions;
    }
    //GET YEAR INSCRIPTIONS
    public function getYearInscriptions($scolaryYearId,$classeId,$costId,$keySearch){
        if ($classeId==0) {
           if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
           }

        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.classe_id',$classeId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('inscriptions.scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            }

        }
        return $inscriptions;
    }
    //GET LAST WEEK INSCRIPTIONS
    public function getYearBetweenInscriptions($dateTo,$dateFrom,$scolaryYearId,$classeId,$costId,$keySearch){
        if ($classeId==0) {
            if ($costId==0) {
                    $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                        ->where('scolary_year_id',$scolaryYearId)
                        ->orderBy('inscriptions.created_at','DESC')
                        ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                        ->where('inscriptions.active',true)
                        ->where('inscriptions.is_paied',true)
                        ->where('students.name','Like','%'.$keySearch.'%')
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            } else {
                    $inscriptions=Inscription::select('students.*','inscriptions.*')
                        ->join('students','inscriptions.student_id','=','students.id')
                        ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                        ->where('scolary_year_id',$scolaryYearId)
                        ->where('inscriptions.classe_id',$classeId)
                        ->where('students.name','Like','%'.$keySearch.'%')
                        ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                        ->orderBy('inscriptions.created_at','DESC')
                        ->where('inscriptions.active',true)
                        ->where('inscriptions.is_paied',true)
                        ->with('cost')
                        ->with('student')
                        ->with('student.classe')
                        ->with('student.classe.option')
                        ->get();
            }
        } else {
            if ($costId==0) {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.classe_id',$classeId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            } else {
                $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->join('cost_inscriptions','cost_inscriptions.id','=','inscriptions.cost_inscription_id')
                    ->where('scolary_year_id',$scolaryYearId)
                    ->where('inscriptions.classe_id',$classeId)
                    ->where('inscriptions.cost_inscription_id',$costId)
                    ->orderBy('inscriptions.created_at','DESC')
                    ->where('inscriptions.active',true)
                    ->where('inscriptions.is_paied',true)
                    ->where('students.name','Like','%'.$keySearch.'%')
                    ->whereBetween('inscriptions.created_at',[$dateTo,$dateFrom])
                    ->with('cost')
                    ->with('student')
                    ->with('student.classe')
                    ->with('student.classe.option')
                    ->get();
            }
        }
        return $inscriptions;
    }
    //GET BY SCOLARY YEAR INSCRIPTIONS

    public function getByScolaryYear($scolaryYearId,$keySearch){
        $inscriptions=Inscription::select('students.*','inscriptions.*')
        ->join('students','inscriptions.student_id','=','students.id')
        ->where('inscriptions.scolary_year_id',$scolaryYearId)
        ->where('students.name','Like','%'.$keySearch.'%')
        ->orderBy('students.name','ASC')
        ->where('inscriptions.active',true)
        ->with('student')
        ->with('student.classe')
        ->with('student.classe.option')
        ->get();

        return $inscriptions;
    }

    public function getByScolaryYearByClasse($scolaryYearId,$keySearch,$classeId){
        $inscriptions=Inscription::select('students.*','inscriptions.*')
                ->join('students','inscriptions.student_id','=','students.id')
                ->where('inscriptions.classe_id',$classeId)
                ->where('inscriptions.scolary_year_id',$scolaryYearId)
                ->where('students.name','Like','%'.$keySearch.'%')
                ->orderBy('students.name','ASC')
                ->where('inscriptions.active',true)
                ->with('student')
                ->with('student.classe')
                ->with('student.classe.option')
                ->get();
        return $inscriptions;
    }


}
