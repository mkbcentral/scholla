<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SourceReq extends Model
{
    use HasFactory;
    protected $fillable=['name','solde'];

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class);
    }
}
