<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use Illuminate\Http\Request;
use App\Imports\DataLatihImport;
use Maatwebsite\Excel\Facades\Excel;

class DataLatihController extends Controller
{
    public function index()
    {
        $data_latih = DataLatih::all();

        return view('data-latih.index', compact('data_latih'));
    }

    public function import()
    {
        return view('data-latih.import');
    }

    public function import_post(Request $request)
    {
        $file = $request->file('file');

        DataLatih::truncate();
        
        Excel::import(new DataLatihImport, $file);

        return redirect('/data-latih');
    }
}
