<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostInscription extends Model
{
    use HasFactory;
    protected $fillable=['name','amount'];

    /**
     * Get all of the Inscription for the CostInscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }
}
