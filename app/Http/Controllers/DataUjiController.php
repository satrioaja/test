<?php

namespace App\Http\Controllers;

use App\Models\DataUji;
use App\Models\Pengujian;
use Illuminate\Http\Request;

class DataUjiController extends Controller
{
    public function index(Request $request)
    {
        $pengujian = Pengujian::all();

        $filter = $request->filter;

        if (!$filter && $pengujian->count()) {
            $filter = $pengujian->last()->id;
        }

        $data_uji = DataUji::when($filter, function ($query) use ($filter) {
            $query->where('pengujian_id', $filter);
        })->get();

        return view('data-uji.index', compact('data_uji', 'pengujian', 'filter'));
    }
}
