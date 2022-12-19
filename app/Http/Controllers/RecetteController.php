<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\TypeOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RecetteController extends Controller
{
    public function printRecettes($month){
        $costs=TypeOtherCost::all();
        $inscription=Inscription::
            join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
            ->whereMonth('inscriptions.created_at',$month)
            ->where('inscriptions.is_paied',true)
            ->sum('cost_inscriptions.amount');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.recettes.print-recettes',
            compact(['costs','month','inscription']));
        return $pdf->stream();
    }
}
