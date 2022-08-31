<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostGeneral extends Model
{
    use HasFactory;
    protected $fillable=['name','amount'];

    /**
     * Get the Paiement associated with the CostGeneral
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiment::class);
    }
}
