<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index(): string
    {
        $data=[
            'title' => 'Dashboard Pegawai',
            'nama' => session()->get('username'),
        ];
        return view('pegawai/home',$data);
    }
    public function presensi_masuk()
    {
        echo "Presensi Masuk Berhasil";
    }
}
