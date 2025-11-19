<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;

class Home extends BaseController
{
    public function index(): string
    
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawai_model = new PegawaiModel();
        $id_pegawai = session()->get('id_pegawai');
        $pegawai = $pegawai_model->where('id', $id_pegawai)->first();
        $data=[
            'title' => 'Dashboard Pegawai',
            'lokasi_presensi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first()
        ];
        return view('pegawai/home',$data);
    }
    public function presensi_masuk()
    {
        echo "Presensi Masuk Berhasil";
    }
}
