<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use App\Imports\DataLatihImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihan = Pelatihan::orderBy('id', 'desc')->get();

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
            'neuron' => 'required',
            'layer' => 'required',
            'learning_rate' => 'required',
            'epoch' => 'required',
            'batch_size' => 'required',
        ]);

        $file = $request->file('file');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/data_latih', $nama_file);

        $pelatihan = Pelatihan::create([
            'nama' => $request->nama,
            'file_data_latih' => $nama_file,
            'file_model' => 'fill after training',
            'neuron' => $request->neuron,
            'layer' => $request->layer,
            'learning_rate' => $request->learning_rate,
            'epoch' => $request->epoch,
            'batch_size' => $request->batch_size,
        ]);

        Excel::import(new DataLatihImport, $file);

        $command = "python3 " . base_path() . "/public/python/training-real.py " . Storage::path('public/data_latih/' . $nama_file) . " " . $request->neuron . " " . $pelatihan->id . " " . $request->layer . " " . $request->learning_rate . " " . $request->epoch . " " . $request->batch_size;

        $output = "";

        exec($command, $output);

        $model_name = $output[0];

        $pelatihan->update([
            'file_model' => $model_name,
        ]);

        return redirect()->route('pelatihan.index')->with('success', 'Model berhasil dibuat');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        Storage::delete('public/data_latih/' . $pelatihan->file_data_latih);
        Storage::delete('public/model/' . $pelatihan->file_model);
        
        $pelatihan->dataLatih()->delete();
        $pelatihan->delete();

        return redirect()->route('pelatihan.index')->with('success', 'Model berhasil dihapus');
    }
}
