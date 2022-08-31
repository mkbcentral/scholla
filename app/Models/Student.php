<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the Inscription associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function inscription(): HasOne
    {
        return $this->hasOne(Inscription::class);
    }

    /**
     * Get the Paiement associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paiement(): HasOne
    {
        return $this->hasOne(Paiment::class);
    }

    /**
     * Get the user that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    /**
     * Get the user that owns the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(StudentResponsable::class, 'student_responsable_id');
    }

    public function getPaiementStatus($mounth,$id,$cost){
        $paimement=Paiment::where('student_id',$id)
                            ->where('mounth_name',$mounth)
                            ->where('cost_general_id',$cost)
                            ->first();
        return $paimement;
    }


}
