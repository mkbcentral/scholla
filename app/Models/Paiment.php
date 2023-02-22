<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paiment extends Model
{
    use HasFactory;

    /**
     * Get the Student that owns the Paiement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the Const that owns the Inscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
        public function cost(): BelongsTo
    {
        return $this->belongsTo(CostGeneral::class, 'cost_general_id');
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function depense(): HasOne
    {
        return $this->hasOne(DepenseInPaiment::class);
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function regularisation(): HasOne
    {
        return $this->hasOne(PaieRegularisation::class);
    }


    public function getArchiveAmount($id){
        $amount=0;
        if ($id==38) {
            $amount=($this->cost->amount * 2000)-40000;
        } elseif($id==37) {
            $amount=($this->cost->amount * 2000)-50000;
        }elseif($id==39) {
            $amount=($this->cost->amount * 2000)-50000;
        }elseif($id==40) {
            $amount=($this->cost->amount * 2000)-60000;
        }elseif($id==41) {
            $amount=($this->cost->amount * 2000)-80000;
        }elseif($id==42) {
            $amount=($this->cost->amount * 2000)-90000;
        }
        return $amount;
    }

}
