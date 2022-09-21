<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisition extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Requisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emetter(): BelongsTo
    {
        return $this->belongsTo(EmitReq::class, 'emit_req_id');
    }

    /**
     * Get the user that owns the Requisition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(SourceReq::class, 'source_req_id');
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailRequisition::class);
    }


    public function getTotal($id)
    {
        $details=DetailRequisition::where('requisition_id',$id)->get();
        $total=0;
        foreach ($details as $detail) {
            if ($detail->active==true) {
                $total +=$detail->amount;
            }
        }
        return $total;
    }
}
