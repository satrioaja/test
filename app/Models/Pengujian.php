<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengujian extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama',
        'pelatihan_id',
        'file_data_uji',
        'file_hasil',
        'rmse',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function dataUji()
    {
        return $this->hasMany(DataUji::class);
    }
}
