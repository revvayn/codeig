<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;
use App\Models\KetidakhadiranModel;
use App\Models\LokasiPresensiModel;

class Rekap extends BaseController
{
    public function harian()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $tanggal      = $this->request->getGet('tanggal') ?: date('Y-m-d');

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $pegawaiModel    = new PegawaiModel();
        $presensiModel   = new PresensiModel();
        $ketidakhadiran  = new KetidakhadiranModel();
        $lokasiModel     = new LokasiPresensiModel();

        $pegawaiList = $pegawaiModel->byPerusahaan($idPerusahaan);
        $presensi    = $presensiModel->byTanggal($tanggal, $idPerusahaan);
        $izin        = $ketidakhadiran->disetujuiTanggal($tanggal, $idPerusahaan);
        $lokasi      = [];

        foreach ($lokasiModel->where('id_perusahaan', $idPerusahaan)->findAll() as $row) {
            $lokasi[(int) $row['id']] = $row;
        }

        $presensiMap = [];
        foreach ($presensi as $row) {
            $presensiMap[(int) $row['id_pegawai']] = $row;
        }

        $izinMap = [];
        foreach ($izin as $row) {
            $izinMap[(int) $row['id_pegawai']] = $row;
        }

        $rekap = [];
        foreach ($pegawaiList as $pegawai) {
            $presensiPegawai = $presensiMap[(int) $pegawai['id']] ?? null;
            $izinPegawai     = $izinMap[(int) $pegawai['id']] ?? null;
            $lokasiPegawai   = $lokasi[(int) $pegawai['lokasi_presensi']] ?? null;

            $status = 'Alpa';
            $jamMasuk = '-';
            $jamKeluar = '-';

            if ($presensiPegawai) {
                $status    = 'Hadir';
                $jamMasuk  = $presensiPegawai['jam_masuk'] ? substr($presensiPegawai['jam_masuk'], 0, 5) : '-';
                $jamKeluar = $presensiPegawai['jam_keluar'] ? substr($presensiPegawai['jam_keluar'], 0, 5) : '-';

                if ($lokasiPegawai && $presensiPegawai['jam_masuk'] && $presensiPegawai['jam_masuk'] > $lokasiPegawai['jam_masuk']) {
                    $status = 'Terlambat';
                }
            } elseif ($izinPegawai) {
                $status = $izinPegawai['keterangan'];
            }

            $rekap[] = [
                'pegawai'    => $pegawai,
                'status'     => $status,
                'jam_masuk'  => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'izin'       => $izinPegawai,
            ];
        }

        return view('admin/rekap/harian', [
            'title'      => 'Rekap Kehadiran Harian',
            'tanggal'    => $tanggal,
            'rekap'      => $rekap,
        ]);
    }

    public function bulanan()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $bulan        = $this->request->getGet('bulan') ?: date('Y-m');

        if (! preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            $bulan = date('Y-m');
        }

        $pegawaiModel   = new PegawaiModel();
        $presensiModel  = new PresensiModel();
        $ketidakhadiran = new KetidakhadiranModel();

        $pegawaiList = $pegawaiModel->byPerusahaan($idPerusahaan);
        $presensi    = $presensiModel->semuaByBulan($bulan, $idPerusahaan);
        $izin        = $ketidakhadiran->disetujuiBulan($bulan, $idPerusahaan);

        $presensiMap = [];
        foreach ($presensi as $row) {
            $presensiMap[(int) $row['id_pegawai']][] = $row;
        }

        $izinMap = [];
        foreach ($izin as $row) {
            $izinMap[(int) $row['id_pegawai']][] = $row;
        }

        $hariKerja = $this->hitungHariKerja($bulan);

        $rekap = [];
        foreach ($pegawaiList as $pegawai) {
            $hadir = count($presensiMap[(int) $pegawai['id']] ?? []);
            $cuti  = ['Izin' => 0, 'Sakit' => 0, 'Cuti' => 0];

            foreach ($izinMap[(int) $pegawai['id']] ?? [] as $row) {
                $keterangan = $row['keterangan'] ?? 'Izin';
                if (isset($cuti[$keterangan])) {
                    $cuti[$keterangan]++;
                }
            }

            $totalIzin = array_sum($cuti);
            $alpa      = max(0, $hariKerja - $hadir - $totalIzin);

            $rekap[] = [
                'pegawai'   => $pegawai,
                'hadir'     => $hadir,
                'izin'      => $cuti['Izin'],
                'sakit'     => $cuti['Sakit'],
                'cuti'      => $cuti['Cuti'],
                'alpa'      => $alpa,
                'hari_kerja'=> $hariKerja,
            ];
        }

        [$tahun, $angkaBulan] = array_map('intval', explode('-', $bulan));

        return view('admin/rekap/bulanan', [
            'title'        => 'Rekap Kehadiran Bulanan',
            'bulan'        => $bulan,
            'nama_bulan'   => nama_bulan($angkaBulan) . ' ' . $tahun,
            'hari_kerja'   => $hariKerja,
            'rekap'        => $rekap,
        ]);
    }

    public function exportHarian()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $tanggal      = $this->request->getGet('tanggal') ?: date('Y-m-d');
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $pegawaiModel   = new PegawaiModel();
        $presensiModel  = new PresensiModel();
        $ketidakhadiran = new KetidakhadiranModel();
        $lokasiModel    = new LokasiPresensiModel();

        $pegawaiList = $pegawaiModel->byPerusahaan($idPerusahaan);
        $presensi    = $presensiModel->byTanggal($tanggal, $idPerusahaan);
        $izin        = $ketidakhadiran->disetujuiTanggal($tanggal, $idPerusahaan);

        $lokasi = [];
        foreach ($lokasiModel->where('id_perusahaan', $idPerusahaan)->findAll() as $row) {
            $lokasi[(int) $row['id']] = $row;
        }

        $presensiMap = [];
        foreach ($presensi as $row) {
            $presensiMap[(int) $row['id_pegawai']] = $row;
        }
        $izinMap = [];
        foreach ($izin as $row) {
            $izinMap[(int) $row['id_pegawai']] = $row;
        }

        $filename = 'rekap-harian-' . $tanggal . '.csv';
        $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['NIP', 'Nama', 'Status', 'Jam Masuk', 'Jam Keluar', 'Keterangan']);

        foreach ($pegawaiList as $pegawai) {
            $presensiPegawai = $presensiMap[(int) $pegawai['id']] ?? null;
            $izinPegawai     = $izinMap[(int) $pegawai['id']] ?? null;
            $lokasiPegawai   = $lokasi[(int) $pegawai['lokasi_presensi']] ?? null;

            $status    = 'Alpa';
            $jamMasuk  = '-';
            $jamKeluar = '-';
            $ket       = '';

            if ($presensiPegawai) {
                $status    = 'Hadir';
                $jamMasuk  = $presensiPegawai['jam_masuk'] ? substr($presensiPegawai['jam_masuk'], 0, 5) : '-';
                $jamKeluar = $presensiPegawai['jam_keluar'] ? substr($presensiPegawai['jam_keluar'], 0, 5) : '-';
                if ($lokasiPegawai && $presensiPegawai['jam_masuk'] && $presensiPegawai['jam_masuk'] > $lokasiPegawai['jam_masuk']) {
                    $status = 'Terlambat';
                }
            } elseif ($izinPegawai) {
                $status = $izinPegawai['keterangan'];
                $ket    = $izinPegawai['deskripsi'] ?? '';
            }

            fputcsv($out, [
                $pegawai['nip'],
                $pegawai['nama'],
                $status,
                $jamMasuk,
                $jamKeluar,
                $ket,
            ]);
        }

        fclose($out);
        return $this->response;
    }

    public function exportBulanan()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $bulan        = $this->request->getGet('bulan') ?: date('Y-m');
        if (! preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            $bulan = date('Y-m');
        }

        $pegawaiModel   = new PegawaiModel();
        $presensiModel  = new PresensiModel();
        $ketidakhadiran = new KetidakhadiranModel();

        $pegawaiList = $pegawaiModel->byPerusahaan($idPerusahaan);
        $presensi    = $presensiModel->semuaByBulan($bulan, $idPerusahaan);
        $izin        = $ketidakhadiran->disetujuiBulan($bulan, $idPerusahaan);

        $presensiMap = [];
        foreach ($presensi as $row) {
            $presensiMap[(int) $row['id_pegawai']][] = $row;
        }
        $izinMap = [];
        foreach ($izin as $row) {
            $izinMap[(int) $row['id_pegawai']][] = $row;
        }

        $hariKerja = $this->hitungHariKerja($bulan);

        $filename = 'rekap-bulanan-' . $bulan . '.csv';
        $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['NIP', 'Nama', 'Hari Kerja', 'Hadir', 'Izin', 'Sakit', 'Cuti', 'Alpa']);

        foreach ($pegawaiList as $pegawai) {
            $hadir = count($presensiMap[(int) $pegawai['id']] ?? []);
            $cuti  = ['Izin' => 0, 'Sakit' => 0, 'Cuti' => 0];
            foreach ($izinMap[(int) $pegawai['id']] ?? [] as $row) {
                $keterangan = $row['keterangan'] ?? 'Izin';
                if (isset($cuti[$keterangan])) {
                    $cuti[$keterangan]++;
                }
            }
            $totalIzin = array_sum($cuti);
            $alpa      = max(0, $hariKerja - $hadir - $totalIzin);

            fputcsv($out, [
                $pegawai['nip'],
                $pegawai['nama'],
                $hariKerja,
                $hadir,
                $cuti['Izin'],
                $cuti['Sakit'],
                $cuti['Cuti'],
                $alpa,
            ]);
        }

        fclose($out);
        return $this->response;
    }

    private function hitungHariKerja(string $bulan): int
    {
        $awal  = new \DateTime($bulan . '-01');
        $akhir = (clone $awal)->modify('last day of this month');

        if ($bulan === date('Y-m')) {
            $hariIni = new \DateTime(date('Y-m-d'));
            if ($hariIni < $akhir) {
                $akhir = $hariIni;
            }
        }

        $jumlah = 0;
        $cursor = clone $awal;

        while ($cursor <= $akhir) {
            if ((int) $cursor->format('N') <= 5) {
                $jumlah++;
            }
            $cursor->modify('+1 day');
        }

        return $jumlah;
    }
}
