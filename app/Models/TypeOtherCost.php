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

    public function getTotal($month,$id){
        $paiment=Paiment::join('cost_generals','paiments.cost_general_id','=','cost_generals.id')
                ->join('type_other_costs','cost_generals.type_other_cost_id','=','type_other_costs.id')
                ->where('type_other_costs.id',$id)
                ->where('paiments.mounth_name',$month)
                //->where('paiments.is_paied',true)
                ->sum('cost_generals.amount');
        return $paiment;
    }
}
