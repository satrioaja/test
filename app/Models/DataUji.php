<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUji extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'market_cap',
        'pengujian_id'
    ];
}
