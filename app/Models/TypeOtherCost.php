<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeOtherCost extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    /**
     * Get all of the comments for the TypeOtherCost
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs(): HasMany
    {
        return $this->hasMany(CostGeneral::class);
    }

    public function getTotal($month,$id,$idSColaryYear){

        $paiments=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->where('paiments.mounth_name',$month)
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->get();
        $total=0;
        foreach ($paiments as $paiment) {

            $amount=0;
            if ($paiment->cost->id==38) {
                //dd($paiment->cost->name)8000;
                $amount=($paiment->cost->amount*2000)-8000;

            } elseif($paiment->cost->id==37) {
                //$amount=10000;
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==39) {
                //$amount=10000;
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==40) {
                //$amount=12000;
                $amount=($paiment->cost->amount*2000)-12000;
            }elseif($paiment->cost->id==41) {
                //$amount=16000;
                dd($paiment->cost->name);
            }elseif($paiment->cost->id==42) {
                //$amount=18000;
                $amount=($paiment->cost->amount*2000)-18000;
            }else{
                $amount=$paiment->cost->amount*2000;
            }
            $total+=$amount;
        }


        /*
        $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->where('paiments.mounth_name',$month)
                ->where('paiments.scolary_year_id',$idSColaryYear)
                //->where('paiments.is_paied',true)
                ->sum('cost_generals.amount');
        */
        return $total;
    }
}
