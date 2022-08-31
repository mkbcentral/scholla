<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Inscription;
use App\Models\ScolaryYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class InscriptionController extends Controller
{
    public function printListStudent($classe_id){
        $classe=Classe::find($classe_id);
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $inscriptions=Inscription::select('students.*','inscriptions.*')
                    ->join('students','inscriptions.student_id','=','students.id')
                    ->where('inscriptions.classe_id',$classe_id)
                    ->where('inscriptions.active',true)
                    ->where('scolary_year_id',$defaultScolaryYer->id)
                    ->orderBy('students.name','ASC')
                    ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.school.prints.liste-student',
        compact(['inscriptions','classe','defaultScolaryYer']));
        return $pdf->stream();
    }
}
