<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use App\Imports\DataLatihImport;
use Maatwebsite\Excel\Facades\Excel;

class DataLatihController extends Controller
{
    public function index(Request $request)
    {
        $pelatihan = Pelatihan::all();

        $filter = $request->filter;

        if (!$filter && $pelatihan->count()) {
            $filter = $pelatihan->last()->id;
        }

        $data_latih = DataLatih::when($filter, function ($query) use ($filter) {
            $query->where('pelatihan_id', $filter);
        })->get();

        return view('data-latih.index', compact('data_latih', 'pelatihan', 'filter'));
    }
}
