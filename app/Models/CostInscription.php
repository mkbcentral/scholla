<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostInscription extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'amount', 'school_id','active'];

    /**
     * Get all of the Inscription for the CostInscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Get the school that owns the CostInscription
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
}
