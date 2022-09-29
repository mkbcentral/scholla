<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inscription extends Model
{
    use HasFactory;

    /**
     * Get the Student that owns the Inscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the Student that owns the Inscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost(): BelongsTo
    {
        return $this->belongsTo(CostInscription::class, 'cost_inscription_id');
    }


    /**
     * Get the user associated with the Inscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function depense(): HasOne
    {
        return $this->hasOne(DepenseInInscription::class);
    }

    /**
     * Get the user associated with the Inscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function regularisation(): HasOne
    {
        return $this->hasOne(InscRegularisation::class);
    }


}
