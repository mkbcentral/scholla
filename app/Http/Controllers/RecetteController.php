<?php

namespace App\Http\Controllers;

use App\Models\TypeOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RecetteController extends Controller
{
    public function printRecettes($month){
        $costs=TypeOtherCost::all();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.recettes.print-recettes',
            compact(['costs','month']));
        return $pdf->stream();
    }
}
