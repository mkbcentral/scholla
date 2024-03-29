<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeOtherCost extends Model
{
    use HasFactory;

    protected $fillable=['name','school_id','active'];

    /**
     * Get all of the comments for the TypeOtherCost
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs(): HasMany
    {
        return $this->hasMany(CostGeneral::class);
    }

    /**
     * Get the school that owns the TypeOtherCost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * Get the scolaryYear that owns the CostInscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scolaryYear(): BelongsTo
    {
        return $this->belongsTo(ScolaryYear::class, 'scolary_year_id');
    }

    public function getTotal($month,$id,$idSColaryYear){
        $paiments=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->where('paiments.mounth_name',$month)
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->with(['cost'])
                ->get();
        $total=0;
        foreach ($paiments as $paiment) {
            $amount=0;
            if ($paiment->cost->id==38) {
                $amount=($paiment->cost->amount*2000)-8000;
            } elseif($paiment->cost->id==37) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==39) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==40) {
                $amount=($paiment->cost->amount*2000)-12000;
            }elseif($paiment->cost->id==41) {
                $amount=($paiment->cost->amount*2000)-16000;
            }elseif($paiment->cost->id==42) {
                $amount=($paiment->cost->amount*2000)-18000;
            }else{
                $amount=$paiment->cost->amount*2000;
            }
            $total+=$amount;
        }

        return $total;
    }

    public function getTotalDate($date,$id,$idSColaryYear){
        $paiments=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->whereDate('paiments.created_at',$date)
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->with(['student.classe.option','student.classe','student','cost','depense','regularisation'])
                ->get();
        $total=0;
        foreach ($paiments as $paiment) {
            $amount=0;
            if ($paiment->cost->id==38) {
                $amount=($paiment->cost->amount*2000)-8000;
            } elseif($paiment->cost->id==37) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==39) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==40) {
                $amount=($paiment->cost->amount*2000)-12000;
            }elseif($paiment->cost->id==41) {
                $amount=($paiment->cost->amount*2000)-16000;
            }elseif($paiment->cost->id==42) {
                $amount=($paiment->cost->amount*2000)-18000;
            }else{
                $amount=$paiment->cost->amount*2000;
            }
            $total+=$amount;
        }

        return $total;
    }

    public function getTotalAll($id,$idSColaryYear){
        $paiments=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->where('paiments.scolary_year_id',$idSColaryYear)
                ->with(['cost','student.classe.option','student.classe','student','cost','depense','regularisation'])
                ->get();
        $total=0;
        foreach ($paiments as $paiment) {
            $amount=0;
            if ($paiment->cost->id==38) {
                $amount=($paiment->cost->amount*2000)-8000;
            } elseif($paiment->cost->id==37) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==39) {
                $amount=($paiment->cost->amount*2000)-10000;
            }elseif($paiment->cost->id==40) {
                $amount=($paiment->cost->amount*2000)-12000;
            }elseif($paiment->cost->id==41) {
                $amount=($paiment->cost->amount*2000)-16000;
            }elseif($paiment->cost->id==42) {
                $amount=($paiment->cost->amount*2000)-18000;
            }else{
                $amount=$paiment->cost->amount*2000;
            }
            $total+=$amount;
        }

        return $total;
    }
}
