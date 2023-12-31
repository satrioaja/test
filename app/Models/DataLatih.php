<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLatih extends Model
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
        'pelatihan_id'
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
