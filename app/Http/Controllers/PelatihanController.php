<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use App\Imports\DataLatihImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = Pelatihan::all();

        $pelatihan->each(function ($item) {
            $item->tanggal = $item->created_at->format('d-m-Y H:i:s');
        });

        return view('pelatihan.index', compact('pelatihan'));
    }

    public function create()
    {
        return view('pelatihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/data_latih', $nama_file);

        Pelatihan::create([
            'nama' => $request->nama,
            'file_data_latih' => $nama_file,
            'file_model' => $nama_file,
        ]);

        Excel::import(new DataLatihImport, $file);

        return redirect()->route('pelatihan.index')->with('success', 'Model berhasil dibuat');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        Storage::delete('public/data_latih/' . $pelatihan->file_data_latih);
        
        $pelatihan->dataLatih()->delete();
        $pelatihan->delete();

        return redirect()->route('pelatihan.index')->with('success', 'Model berhasil dihapus');
    }
}
