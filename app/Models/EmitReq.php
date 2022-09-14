<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmitReq extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class);
    }
}
