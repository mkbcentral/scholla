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
}
