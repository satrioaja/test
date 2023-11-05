<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLatih extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'market_cap',
    ];

    public $timestamps = false;
}
