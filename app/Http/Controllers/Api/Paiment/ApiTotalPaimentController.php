<?php

namespace App\Http\Controllers\Api\Paiment;

use App\Http\Controllers\Controller;
use App\Models\Paiment;
use Illuminate\Http\Request;

class ApiTotalPaimentController extends Controller
{
    public function getTotalBByDay($date){
        $total=0;
        $total_etat=0;
        $paiments=Paiment::whereDate('created_at',$date)->get();
        foreach ($paiments as $paiment) {
            if ($paiment->cost->typeCost->id==6) {
                $total_etat+=$paiment->cost->amount;
            }
            $total+=$paiment->cost->amount;

        }
        return response()->json([
            'total'=>$total*2000,
            'total_etat'=>$total_etat*2000,
            'solde'=>($total*2000)-($total_etat*2000)
        ]);

    }
}
