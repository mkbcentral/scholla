<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostGeneral extends Model
{
    use HasFactory;
    protected $fillable=['name','amount','type_other_cost_id'];

    /**
     * Get the Paiement associated with the CostGeneral
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiment::class);
    }

    /**
     * Get the typ that owns the CostGeneral
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeCost(): BelongsTo
    {
        return $this->belongsTo(TypeOtherCost::class, 'type_other_cost_id');
    }
}
