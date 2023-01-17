<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\ScolaryYear;
use App\Models\TypeOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RecetteController extends Controller
{
    public function printRecettes($month,$scolaryId){
        $costs=TypeOtherCost::all();
        $inscription=Inscription::
            join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
            ->whereMonth('inscriptions.created_at',$month)
            ->where('inscriptions.scolary_year_id',$scolaryId)
            ->where('inscriptions.is_paied',true)
            ->sum('cost_inscriptions.amount');
        $scolarYear=ScolaryYear::find($scolaryId);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.recettes.print-recettes',
            compact(['costs','month','inscription','scolaryId','scolarYear']));
        return $pdf->stream();
    }
}
