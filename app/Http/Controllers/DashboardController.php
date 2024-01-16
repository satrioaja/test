<?php

namespace App\Http\Controllers;

use App\Models\DataUji;
use App\Models\DataLatih;
use App\Models\Pelatihan;
use App\Models\Pengujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $data_pelatihan = Pelatihan::all()->count();
        $data_latih = DataLatih::all()->count();
        $data_pengujian = Pengujian::all()->count();
        $data_uji = DataUji::all()->count();

        $pengujian = Pengujian::orderBy('id', 'desc')->first();
        $hasil_prediksi = [];
        $target = [];
        if ($pengujian) {
            $file_hasil = Storage::get('public/result/' . $pengujian->file_hasil);
            $json = json_decode($file_hasil, true);

            foreach ($json as $key => $value) {
                $hasil_prediksi[] = $value[0];
                $target[] = $value[1];
            }
        }

        return view('dashboard.index', compact('data_pelatihan', 'data_latih', 'data_pengujian', 'data_uji', 'pengujian', 'hasil_prediksi', 'target'));
    }
}
