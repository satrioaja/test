<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'file_data_latih',
        'file_model',
        'neuron',
        'layer',
        'learning_rate',
        'epoch',
        'batch_size',
    ];

    public function dataLatih()
    {
        return $this->hasMany(DataLatih::class);
    }
}
