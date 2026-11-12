<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;

class Home extends BaseController
{
    public function index(): string
    {
        $perusahaanModel = new PerusahaanModel();
        $userModel       = new \App\Models\UserModel();
        $pegawaiModel    = new \App\Models\PegawaiModel();
        $lokasiModel     = new \App\Models\LokasiPresensiModel();

        return view('superadmin/home', [
            'title'            => 'Dashboard Superadmin',
            'total_perusahaan' => $perusahaanModel->countAllResults(),
            'total_admin'      => $userModel->where('role', 'Admin')->countAllResults(),
            'total_superadmin' => $userModel->where('role', 'Superadmin')->countAllResults(),
            'total_pegawai'    => $pegawaiModel->countAllResults(),
            'total_plant'      => $lokasiModel->countAllResults(),
            'perusahaan'       => $perusahaanModel->orderBy('nama_perusahaan', 'ASC')->findAll(),
        ]);
    }
}
