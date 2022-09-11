<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepenseInPaiment extends Model
{
    use HasFactory;

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paiment(): BelongsTo
    {
        return $this->belongsTo(Paiment::class, 'paiment_id');
    }
}
