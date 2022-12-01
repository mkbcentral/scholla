<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\Requisition;
use App\Models\User;
use Illuminate\Http\Request;

class RecttesController extends Controller
{
    //get recettes by day
    public function getRecttesByDay($date){
        $total_deps=0;
        $inscription=Inscription::
                join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
                ->whereDate('inscriptions.created_at',$date)
                ->where('inscriptions.is_paied',true)
                ->sum('cost_inscriptions.amount');
        $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->whereDate('paiments.created_at',$date)
                ->sum('cost_generals.amount');
        $depenses=Requisition::whereDate('created_at',$date)
                ->where('active',true)
                ->get();
            $total_details=0;
            foreach ($depenses as  $depense) {
                foreach ($depense->details as $detail) {
                    if ($detail->active==true) {
                        $total_details+=$detail->amount;
                    }
                }
                $total_deps=$total_details;
            }

        return response()->json([
            'recette'=>[
                'amount_entree'=>$paiment*2000+$inscription*2000,
                'amount_depense'=>$total_deps,
                'solde'=>($paiment*2000+$inscription*2000)-$total_deps
            ]
        ],200);
    }

    public function getByMonth($month){
        $total_deps=0;
        $inscription=Inscription::
        join('cost_inscriptions','inscriptions.cost_inscription_id','=','cost_inscriptions.id')
        ->whereMonth('inscriptions.created_at',$month)
        ->where('inscriptions.is_paied',true)
        ->sum('cost_inscriptions.amount');
        $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
            ->where('paiments.mounth_name',$this->month)
            ->where('paiments.is_paied',true)
            ->sum('cost_generals.amount');
        $depenses=Requisition::whereMonth('created_at',$month)
            ->where('active',true)
            ->get();
        $total_details=0;
        foreach ($depenses as  $depense) {
            foreach ($depense->details as $detail) {
                if ($detail->active==true) {
                    $total_details+=$detail->amount;
                }
            }
            $total_deps=$total_details;
        }
        return response()->json([
            'recette'=>[
                'amount_entree'=>$paiment*2000+$inscription*2000,
                'amount_depense'=>$total_deps,
                'solde'=>($paiment*2000+$inscription*2000)-$total_deps
            ]]
        );
    }
}
