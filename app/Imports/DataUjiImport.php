<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\DataUji;
use App\Models\Pengujian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataUjiImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $pengujian_id;
    
    public function __construct()
    {
        $this->pengujian_id = Pengujian::latest()->first()->id;
    }

    public function model(array $row)
    {
        return new DataUji([
            'date' => Carbon::parse($row['date']),
            'open' => $row['open'],
            'high' => $row['high'],
            'low' => $row['low'],
            'close' => $row['close'],
            'volume' => $row['volume'],
            'market_cap' => $row['marcap'],
            'pengujian_id' => $this->pengujian_id,
        ]);
    }
}
