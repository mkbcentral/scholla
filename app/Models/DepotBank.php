<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepotBank extends Model
{
    use HasFactory;
    protected $casts = [
        'dateTo' => 'date',
        'dateFrom' => 'date',
    ];
}
