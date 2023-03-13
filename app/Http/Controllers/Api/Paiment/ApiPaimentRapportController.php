<?php

namespace App\Http\Controllers\Api\Paiment;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaimentResource;
use App\Http\Resources\TypeOtherCostResource;
use App\Models\Paiment;
use App\Models\Section;
use App\Models\TypeOtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPaimentRapportController extends Controller
{
    //get Cost type
    public function getPaiemntGetMonthPaiments($month)
    {
        $costs = TypeOtherCost::all();
        $paiemnts=array();
        foreach ($costs as $cost) {
            if ($cost->getTotal($month,$cost->id,1)>0) {
                $paiemnts[]=[
                    'name'=>$cost->name,
                    'amount'=>$cost->getTotal($month,$cost->id,1)
                   ];
            }

        }
        return response()->json([
            'recettes'=>$paiemnts
        ],200);
    }

    public function getPaiemntGetDate($date)
    {
        $costs=TypeOtherCost::join('cost_generals','cost_generals.type_other_cost_id','=','type_other_costs.id')
        ->join('paiments','paiments.cost_general_id','=','cost_generals.id')
        ->where('paiments.scolary_year_id',1)
        ->select(DB::raw("SUM(cost_generals.amount*2000) as amount,type_other_costs.name"))
            ->groupBy(DB::raw("type_other_costs.name"))
        ->whereDate('paiments.created_at',$date)
        ->get();
        return $costs;
    }

    public function getPaiemntAll($scolaryYear)
    {
        $costs = TypeOtherCost::all();
        $paiemnts=array();
        foreach ($costs as $cost) {
            if ($cost->getTotalAll($cost->id,$scolaryYear)>0) {
                $paiemnts[]=[
                    'name'=>$cost->name,
                    'amount'=>$cost->getTotalAll($cost->id,$scolaryYear)
                   ];
            }

        }
        return response()->json([
            'recettes'=>$paiemnts
        ],200);
    }

    public function getPaiemntGetMonthPaimentsSection($month)
    {
        $paiments = Paiment::select('paiments.*', 'cost_generals.*')
            ->join('cost_generals', 'cost_generals.id', '=', 'paiments.cost_general_id')
            ->join('classes', 'paiments.classe_id', '=', 'classes.id')
            ->join('classe_options', 'classe_options.id', '=', 'classes.classe_option_id')
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->where('paiments.scolary_year_id', 1)
            ->select(DB::raw("sum(cost_generals.amount*2000) as amount,sections.name"))
            ->groupBy('sections.name')
            ->where('paiments.mounth_name', $month)
            ->with(['cost','student','student.classe','student.classe.option'])
            ->get();
        return PaimentResource::collection($paiments);
    }

    //Get by section

    //get Cost type
    public function getPaiemntGetMonthSectionPaiments($month)
    {
        $section = Section::all();
        $paiemnts=array();
        foreach ($section as $cost) {
            if ($cost->getTotal($month,$cost->id,1)>0) {
                $paiemnts[]=[
                    'name'=>$cost->name,
                    'amount'=>$cost->getTotal($month,$cost->id,1)
                   ];
            }

        }
        return response()->json([
            'recettes'=>$paiemnts
        ],200);
    }

    public function getPaiemntGetDateSectionPaiments($date)
    {
        $section = Section::all();
        $paiemnts=array();
        foreach ($section as $cost) {
            if ($cost->getTotalDate($date,$cost->id,1)>0) {
                $paiemnts[]=[
                    'name'=>$cost->name,
                    'amount'=>$cost->getTotalDate($date,$cost->id,1)
                   ];
            }

        }
        return response()->json([
            'recettes'=>$paiemnts
        ],200);
    }

    public function getPaiemntGetAllSectionPaiments($idSColaryYear)
    {
        $section = Section::all();
        $paiemnts=array();
        foreach ($section as $cost) {
            if ($cost->getTotalAll($cost->id,$idSColaryYear)>0) {
                $paiemnts[]=[
                    'name'=>$cost->name,
                    'amount'=>$cost->getTotalAll($cost->id,$idSColaryYear)
                   ];
            }

        }
        return response()->json([
            'recettes'=>$paiemnts
        ],200);
    }
}
