<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubAppLink extends Model
{
    use HasFactory;

    protected $fillable=['name','icon','link','color','app_link_id'];

    /**
     * Get the appLink that owns the AppLink
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appLink(): BelongsTo
    {
        return $this->belongsTo(AppLink::class, 'app_link_id');
    }
}
