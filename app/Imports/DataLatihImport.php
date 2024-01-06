<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\DataLatih;
use App\Models\Pelatihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataLatihImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $pelatihan_id;
    
    public function __construct()
    {
        $this->pelatihan_id = Pelatihan::latest()->first()->id;
    }

    public function model(array $row)
    {
        return new DataLatih([
            'date' => Carbon::parse($row['date']),
            'open' => $row['open'],
            'high' => $row['high'],
            'low' => $row['low'],
            'close' => $row['close'],
            'volume' => $row['volume'],
            'market_cap' => $row['marcap'],
            'pelatihan_id' => $this->pelatihan_id,
        ]);
    }
}
