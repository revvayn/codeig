<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use App\Models\PresensiModel;

class Rekap extends BaseController
{
    public function index()
    {
        $idPegawai = (int) session()->get('id_pegawai');
        $bulan     = $this->request->getGet('bulan') ?: date('Y-m');

        if (! preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            $bulan = date('Y-m');
        }

        $presensiModel       = new PresensiModel();
        $ketidakhadiranModel = new KetidakhadiranModel();

        $rows = $presensiModel->byBulan($idPegawai, $bulan);
        $izin = $ketidakhadiranModel->byBulan($idPegawai, $bulan);

        [$tahun, $angkaBulan] = array_map('intval', explode('-', $bulan));

        return view('pegawai/rekap', [
            'title'      => 'Rekap Kehadiran',
            'bulan'      => $bulan,
            'nama_bulan' => nama_bulan($angkaBulan) . ' ' . $tahun,
            'presensi'   => $rows,
            'izin'       => $izin,
            'total_hadir'=> count($rows),
        ]);
    }
}
