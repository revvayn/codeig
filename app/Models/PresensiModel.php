<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table         = 'presensi';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id_pegawai',
        'tanggal_masuk',
        'jam_masuk',
        'foto_masuk',
        'tanggal_keluar',
        'jam_keluar',
        'foto_keluar',
    ];

    public function hariIni(int $idPegawai)
    {
        return $this->where('id_pegawai', $idPegawai)
            ->where('tanggal_masuk', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->first();
    }

    public function riwayat(int $idPegawai, int $limit = 10)
    {
        return $this->where('id_pegawai', $idPegawai)
            ->orderBy('tanggal_masuk', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll($limit);
    }

    public function byBulan(int $idPegawai, string $bulan)
    {
        return $this->like('tanggal_masuk', $bulan, 'after')
            ->orderBy('tanggal_masuk', 'DESC')
            ->findAll();
    }

    public function byTanggal(string $tanggal, ?int $idPerusahaan = null): array
    {
        $builder = $this->db->table('presensi p')
            ->select('p.*, pg.nama, pg.nip, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = p.id_pegawai')
            ->where('p.tanggal_masuk', $tanggal)
            ->orderBy('p.jam_masuk', 'ASC');

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->get()->getResultArray();
    }

    public function semuaByBulan(string $bulan, ?int $idPerusahaan = null): array
    {
        $builder = $this->db->table('presensi p')
            ->select('p.*, pg.nama, pg.nip, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = p.id_pegawai')
            ->like('p.tanggal_masuk', $bulan, 'after')
            ->orderBy('p.tanggal_masuk', 'ASC');

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->get()->getResultArray();
    }

    public function jumlahHadirTanggal(string $tanggal, ?int $idPerusahaan = null): int
    {
        $builder = $this->db->table('presensi p')
            ->join('pegawai pg', 'pg.id = p.id_pegawai')
            ->where('p.tanggal_masuk', $tanggal);

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->countAllResults();
    }
}
