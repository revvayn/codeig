<?php

use App\Models\PerusahaanModel;

if (! function_exists('zona_waktu_php')) {
    /**
     * Konversi kode zona waktu Indonesia ke nama timezone PHP.
     */
    function zona_waktu_php(?string $zona): string
    {
        return match (strtoupper((string) $zona)) {
            'WITA' => 'Asia/Makassar',
            'WIT'  => 'Asia/Jayapura',
            default => 'Asia/Jakarta',
        };
    }
}

if (! function_exists('hitung_jarak_meter')) {
    /**
     * Hitung jarak dua koordinat memakai rumus Haversine (meter).
     */
    function hitung_jarak_meter($lat1, $lng1, $lat2, $lng2): float
    {
        $lat1 = (float) $lat1;
        $lng1 = (float) $lng1;
        $lat2 = (float) $lat2;
        $lng2 = (float) $lng2;

        if ($lat1 === 0.0 && $lng1 === 0.0) {
            return 0.0;
        }

        $earthRadius = 6371000;
        $dLat        = deg2rad($lat2 - $lat1);
        $dLng        = deg2rad($lng2 - $lng1);
        $a           = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return round($earthRadius * 2 * asin(sqrt($a)), 2);
    }
}

if (! function_exists('tanggal_indo')) {
    /**
     * Format tanggal menjadi "12 November 2026".
     */
    function tanggal_indo(?string $tanggal, bool $denganHari = false): string
    {
        if (empty($tanggal)) {
            return '-';
        }

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];
        $hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        try {
            $date = new DateTime($tanggal);
        } catch (Exception $e) {
            return '-';
        }

        $hasil = $date->format('j') . ' ' . $bulan[(int) $date->format('n')] . ' ' . $date->format('Y');

        if ($denganHari) {
            $hasil = $hari[$date->format('l')] . ', ' . $hasil;
        }

        return $hasil;
    }
}

if (! function_exists('badge_kehadiran')) {
    /**
     * Badge HTML untuk status kehadiran.
     */
    function badge_kehadiran(?string $status): string
    {
        $status = trim((string) $status);

        $map = [
            'Hadir'       => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'Terlambat'   => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'Izin'        => 'bg-sky-50 text-sky-700 ring-sky-600/20',
            'Sakit'       => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
            'Cuti'        => 'bg-violet-50 text-violet-700 ring-violet-600/20',
            'Alpa'        => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'Menunggu'    => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'Disetujui'   => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'Ditolak'     => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'Aktif'       => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'Tidak Aktif' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
        ];

        $kelas = $map[$status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20';

        return '<span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset ' . $kelas . '">'
            . '<span class="h-1.5 w-1.5 rounded-full bg-current opacity-70"></span>'
            . esc($status) . '</span>';
    }
}

if (! function_exists('foto_profil_url')) {
    /**
     * URL foto profil pegawai, dengan fallback ke avatar default.
     */
    function foto_profil_url(?string $nama): string
    {
        if (! empty($nama) && is_file(FCPATH . 'profile/' . $nama)) {
            return base_url('profile/' . $nama);
        }

        return base_url('assets/img/team-1.jpg');
    }
}

if (! function_exists('foto_presensi_url')) {
    /**
     * URL foto presensi. Foto dapat berasal dari upload presensi lama
     * maupun foto dasar profil pegawai (alur presensi saat ini).
     */
    function foto_presensi_url(?string $nama): string
    {
        if (empty($nama)) {
            return '';
        }

        if (is_file(FCPATH . 'uploads/presensi/' . $nama)) {
            return base_url('uploads/presensi/' . $nama);
        }

        if (is_file(FCPATH . 'profile/' . $nama)) {
            return base_url('profile/' . $nama);
        }

        return '';
    }
}

if (! function_exists('nama_bulan')) {
    function nama_bulan(int $bulan): string
    {
        $daftar = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        return $daftar[$bulan] ?? '-';
    }
}

if (! function_exists('perusahaan_aktif')) {
    /**
     * Daftar perusahaan aktif (dipakai halaman login).
     */
    function perusahaan_aktif(): array
    {
        try {
            return (new PerusahaanModel())->where('status', 'Aktif')->orderBy('nama_perusahaan')->findAll();
        } catch (Throwable $e) {
            return [];
        }
    }
}
