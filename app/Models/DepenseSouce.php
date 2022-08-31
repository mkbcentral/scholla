<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepenseSouce extends Model
{
    protected $fillable=['name','solde'];
    use HasFactory;

    /**
     * Get all of the depenses for the DepenseSouce
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }
}
