<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;

class Home extends BaseController
{
    public function index(): string
    {
        $idPegawai = (int) session()->get('id_pegawai');

        $pegawaiModel        = new PegawaiModel();
        $lokasiModel         = new LokasiPresensiModel();
        $presensiModel       = new PresensiModel();
        $ketidakhadiranModel = new KetidakhadiranModel();

        $pegawai = $pegawaiModel->find($idPegawai);
        $lokasi  = $pegawai ? $lokasiModel->find($pegawai['lokasi_presensi']) : null;

        // Fallback ke GPS default perusahaan jika pegawai belum di-assign plant.
        if (! $lokasi && $pegawai) {
            $perusahaan = (new \App\Models\PerusahaanModel())->find($pegawai['id_perusahaan']);
            if ($perusahaan && ! empty($perusahaan['latitude'])) {
                $lokasi = [
                    'id'            => 0,
                    'nama_lokasi'   => $perusahaan['nama_perusahaan'],
                    'alamat_lokasi' => $perusahaan['alamat'] ?? '',
                    'latitude'      => $perusahaan['latitude'],
                    'longitude'     => $perusahaan['longitude'],
                    'radius'        => $perusahaan['radius'] ?? 20,
                    'zona_waktu'    => $perusahaan['zona_waktu'] ?? 'WIB',
                    'jam_masuk'     => $perusahaan['jam_masuk'] ?? '08:00:00',
                    'jam_pulang'    => $perusahaan['jam_pulang'] ?? '17:00:00',
                ];
            }
        }

        if ($lokasi) {
            date_default_timezone_set(zona_waktu_php($lokasi['zona_waktu']));
        }

        $hariIni   = $presensiModel->hariIni($idPegawai);
        $riwayat   = $presensiModel->riwayat($idPegawai, 7);
        $bulanIni  = date('Y-m');
        $bulanRows = $presensiModel->byBulan($idPegawai, $bulanIni);

        $izinBulanIni = array_filter(
            $ketidakhadiranModel->byBulan($idPegawai, $bulanIni),
            static fn ($row) => ($row['status_pengajuan'] ?? '') === 'Disetujui'
        );

        $data = [
            'title'           => 'Dashboard Pegawai',
            'pegawai'         => $pegawai,
            'lokasi_presensi' => $lokasi,
            'presensi_hari_ini' => $hariIni,
            'riwayat'         => $riwayat,
            'total_hadir'     => count($bulanRows),
            'total_izin'      => count($izinBulanIni),
            'tanggal_hari_ini'=> tanggal_indo(date('Y-m-d'), true),
        ];

        return view('pegawai/home', $data);
    }

    public function presensi_masuk()
    {
        $idPegawai = (int) session()->get('id_pegawai');
        $pegawai   = (new PegawaiModel())->find($idPegawai);

        if (! $pegawai) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan.');
            return redirect()->to(base_url('pegawai/home'));
        }

        $lokasi = (new LokasiPresensiModel())->find($pegawai['lokasi_presensi']);
        if (! $lokasi) {
            session()->setFlashdata('error', 'Lokasi presensi Anda belum diatur. Hubungi admin.');
            return redirect()->to(base_url('pegawai/home'));
        }

        date_default_timezone_set(zona_waktu_php($lokasi['zona_waktu']));

        $presensiModel = new PresensiModel();
        if ($presensiModel->hariIni($idPegawai)) {
            session()->setFlashdata('error', 'Anda sudah melakukan presensi masuk hari ini.');
            return redirect()->to(base_url('pegawai/home'));
        }

        $jarak = $this->validasiLokasi($lokasi);
        if ($jarak === false) {
            return redirect()->to(base_url('pegawai/home'));
        }

        $fotoName = $this->simpanFoto('foto_masuk');
        if ($fotoName === false) {
            return redirect()->to(base_url('pegawai/home'));
        }
        if ($fotoName === '') {
            $fotoName = $pegawai['foto'] ?? '';
        }

        $presensiModel->insert([
            'id_pegawai'     => $idPegawai,
            'tanggal_masuk'  => date('Y-m-d'),
            'jam_masuk'      => date('H:i:s'),
            'foto_masuk'     => $fotoName,
            'tanggal_keluar' => null,
            'jam_keluar'     => null,
            'foto_keluar'    => null,
        ]);

        $keterangan = date('H:i:s') > $lokasi['jam_masuk'] ? ' (terlambat)' : '';
        session()->setFlashdata('success', 'Presensi masuk berhasil dicatat' . $keterangan . '.');

        return redirect()->to(base_url('pegawai/home'));
    }

    public function presensi_pulang()
    {
        $idPegawai = (int) session()->get('id_pegawai');
        $pegawai   = (new PegawaiModel())->find($idPegawai);

        if (! $pegawai) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan.');
            return redirect()->to(base_url('pegawai/home'));
        }

        $lokasi = (new LokasiPresensiModel())->find($pegawai['lokasi_presensi']);
        if (! $lokasi) {
            session()->setFlashdata('error', 'Lokasi presensi Anda belum diatur. Hubungi admin.');
            return redirect()->to(base_url('pegawai/home'));
        }

        date_default_timezone_set(zona_waktu_php($lokasi['zona_waktu']));

        $presensiModel = new PresensiModel();
        $presensi      = $presensiModel->hariIni($idPegawai);

        if (! $presensi) {
            session()->setFlashdata('error', 'Anda belum melakukan presensi masuk hari ini.');
            return redirect()->to(base_url('pegawai/home'));
        }

        if (! empty($presensi['jam_keluar'])) {
            session()->setFlashdata('error', 'Anda sudah melakukan presensi pulang hari ini.');
            return redirect()->to(base_url('pegawai/home'));
        }

        $jarak = $this->validasiLokasi($lokasi);
        if ($jarak === false) {
            return redirect()->to(base_url('pegawai/home'));
        }

        $fotoName = $this->simpanFoto('foto_keluar');
        if ($fotoName === false) {
            return redirect()->to(base_url('pegawai/home'));
        }
        if ($fotoName === '') {
            $fotoName = $pegawai['foto'] ?? '';
        }

        $presensiModel->update($presensi['id'], [
            'tanggal_keluar' => date('Y-m-d'),
            'jam_keluar'     => date('H:i:s'),
            'foto_keluar'    => $fotoName,
        ]);

        session()->setFlashdata('success', 'Presensi pulang berhasil dicatat.');

        return redirect()->to(base_url('pegawai/home'));
    }

    /**
     * Validasi posisi GPS terhadap radius lokasi presensi.
     *
     * @return float|false Jarak dalam meter, atau false jika gagal.
     */
    private function validasiLokasi(array $lokasi)
    {
        $lat = $this->request->getPost('latitude');
        $lng = $this->request->getPost('longitude');

        if ($lat === null || $lng === null || $lat === '' || $lng === '') {
            session()->setFlashdata('error', 'Lokasi GPS tidak terdeteksi. Aktifkan GPS lalu izinkan akses lokasi pada browser.');
            return false;
        }

        $jarak = hitung_jarak_meter($lat, $lng, $lokasi['latitude'], $lokasi['longitude']);
        $radius = (float) $lokasi['radius'];

        if ($jarak > $radius) {
            session()->setFlashdata(
                'error',
                'Anda berada di luar radius lokasi presensi. Jarak Anda ' . round($jarak) . ' m, maksimal ' . round($radius) . ' m dari ' . $lokasi['nama_lokasi'] . '.'
            );
            return false;
        }

        return $jarak;
    }

    /**
     * Simpan foto presensi (opsional).
     *
     * @return string|false Nama file, string kosong jika tidak ada foto, atau false jika gagal.
     */
    private function simpanFoto(string $field)
    {
        $foto = $this->request->getFile($field);

        if (! $foto || ! $foto->isValid() || $foto->hasMoved()) {
            return '';
        }

        if ($foto->getSize() > 5 * 1024 * 1024) {
            session()->setFlashdata('error', 'Ukuran foto maksimal 5 MB.');
            return false;
        }

        if (! in_array($foto->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true)) {
            session()->setFlashdata('error', 'Format foto harus JPG, PNG, atau WEBP.');
            return false;
        }

        $folder = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'presensi';
        if (! is_dir($folder)) {
            mkdir($folder, 0775, true);
        }

        $nama = $foto->getRandomName();
        $foto->move($folder, $nama);

        return $nama;
    }
}
