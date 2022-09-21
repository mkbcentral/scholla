<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RequisitionController extends Controller
{
    public function printRequisition($requisitionId){
        $requisition=Requisition::find($requisitionId);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.depense.prints.print-requisition',
        compact(['requisition']));
        return $pdf->stream();
    }

    public function printRapportRequisition($status,$month,$date){
        if ($status==0) {
            $requisitions=Requisition::orderBy('created_at','ASC')
                ->with('details')
                ->whereMonth('created_at',$month)
                ->get();
        } else {
            $requisitions=Requisition::orderBy('created_at','ASC')
                ->with('details')
                ->whereDate('created_at',$date)
                ->get();
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.depense.prints.print-requisition-rapport',
        compact(['requisitions']));
        return $pdf->stream();
    }
}
