<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\Pengujian;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Imports\DataUjiImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PengujianController extends Controller
{
    public function index()
    {
        $pengujian = Pengujian::orderBy('id', 'desc')->get();

        $pengujian->each(function ($item) {
            $item->tanggal = $item->created_at->format('d-m-Y H:i:s');
        });

        return view('pengujian.index', compact('pengujian'));
    }

    public function create()
    {
        $pelatihan = Pelatihan::orderBy('id', 'desc')->get();

        return view('pengujian.create', compact('pelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'file' => 'required|mimes:csv,txt',
            'pelatihan_id' => 'required',
        ]);

        $file = $request->file('file');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/data_uji', $nama_file);

        $pengujian = Pengujian::create([
            'nama' => $request->nama,
            'pelatihan_id' => $request->pelatihan_id,
            'file_data_uji' => $nama_file,
            'file_hasil' => 'fill after testing',
        ]);

        $pelatihan = Pelatihan::find($request->pelatihan_id);

        Excel::import(new DataUjiImport, $file);

        $command = "python3 " . base_path() . "/public/python/predict.py " . Storage::path('public/model/' . $pelatihan->file_model) . " " . Storage::path('public/data_uji/' . $nama_file) . " " . $pengujian->id;

        $output = "";

        exec($command, $output);

        $json_name = Arr::last($output);

        File::move(public_path($json_name), public_path('storage/result/' . $json_name));

        $pengujian->update([
            'file_hasil' => $json_name,
        ]);

        return redirect()->route('pengujian.index')->with('success', 'Pengujian berhasil dilakukan');
    }

    public function destroy($id)
    {
        $pengujian = Pengujian::findOrFail($id);

        Storage::delete('public/data_uji/' . $pengujian->file_data_uji);
        Storage::delete('public/result/' . $pengujian->file_hasil);
        
        $pengujian->dataUji()->delete();
        $pengujian->delete();

        return redirect()->route('pengujian.index')->with('success', 'Pengujian berhasil dihapus');
    }

    public function chart($id)
    {
        $pengujian = Pengujian::findOrFail($id);

        $file_hasil = Storage::get('public/result/' . $pengujian->file_hasil);

        $json = json_decode($file_hasil, true);

        $hasil_prediksi = [];
        $data_uji = [];

        foreach ($json as $key => $value) {
            $hasil_prediksi[] = $value[0];
            $data_uji[] = $value[1];
        }

        return view('pengujian.chart', compact('id', 'pengujian', 'hasil_prediksi', 'data_uji'));
    }
}
