<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;
use App\Models\KetidakhadiranModel;

class Home extends BaseController
{
    public function index(): string
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $tanggal      = date('Y-m-d');

        $pegawaiModel      = new PegawaiModel();
        $presensiModel     = new PresensiModel();
        $ketidakhadiranModel = new KetidakhadiranModel();

        $totalPegawai = $pegawaiModel->where('id_perusahaan', $idPerusahaan)->countAllResults();
        $hadir        = $presensiModel->jumlahHadirTanggal($tanggal, $idPerusahaan);
        $izin         = $ketidakhadiranModel->jumlahDisetujuiTanggal($tanggal, $idPerusahaan);
        $alpa         = max(0, $totalPegawai - $hadir - $izin);

        $presensiHariIni = $presensiModel->byTanggal($tanggal, $idPerusahaan);

        $data = [
            'title'            => 'Dashboard Admin',
            'total_pegawai'    => $totalPegawai,
            'hadir'            => $hadir,
            'izin'             => $izin,
            'alpa'             => $alpa,
            'presensi_hari_ini'=> $presensiHariIni,
            'tanggal'          => $tanggal,
        ];

        return view('admin/home', $data);
    }
}
