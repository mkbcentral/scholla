<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InscRegularisation extends Model
{
    use HasFactory;

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }
}
