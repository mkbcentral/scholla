<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;
    protected $fillable=['name','classe_option_id'];

    /**
     * Get the OptionClasse that owns the Classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function option(): BelongsTo
    {
        return $this->belongsTo(ClasseOption::class, 'classe_option_id');
    }

    /**
     * Get all of the comments for the Classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function classeOption(): BelongsTo
    {
        return $this->belongsTo(ClasseOption::class, 'classe_option_id');
    }
}
