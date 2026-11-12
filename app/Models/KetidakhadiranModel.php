<?php

namespace App\Models;

use CodeIgniter\Model;

class KetidakhadiranModel extends Model
{
    protected $table         = 'ketidakhadiran';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id_pegawai',
        'keterangan',
        'tanggal',
        'deskripsi',
        'file',
        'status_pengajuan',
    ];

    public function byPegawai(int $idPegawai)
    {
        return $this->where('id_pegawai', $idPegawai)
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    public function byBulan(int $idPegawai, string $bulan)
    {
        return $this->where('id_pegawai', $idPegawai)
            ->like('tanggal', $bulan, 'after')
            ->orderBy('tanggal', 'ASC')
            ->findAll();
    }

    public function denganPegawai(?int $idPerusahaan = null, ?string $status = null)
    {
        $builder = $this->db->table('ketidakhadiran k')
            ->select('k.*, pg.nama, pg.nip, pg.foto, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = k.id_pegawai')
            ->orderBy('k.tanggal', 'DESC');

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }
        if (! empty($status)) {
            $builder->where('k.status_pengajuan', $status);
        }

        return $builder->get()->getResultArray();
    }

    public function denganPegawaiById(int $id)
    {
        return $this->db->table('ketidakhadiran k')
            ->select('k.*, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = k.id_pegawai')
            ->where('k.id', $id)
            ->get()
            ->getRowArray();
    }

    public function disetujuiTanggal(string $tanggal, ?int $idPerusahaan = null): array
    {
        $builder = $this->db->table('ketidakhadiran k')
            ->select('k.*, pg.nama, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = k.id_pegawai')
            ->where('k.tanggal', $tanggal)
            ->where('k.status_pengajuan', 'Disetujui');

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->get()->getResultArray();
    }

    public function jumlahDisetujuiTanggal(string $tanggal, ?int $idPerusahaan = null): int
    {
        return count($this->disetujuiTanggal($tanggal, $idPerusahaan));
    }

    public function disetujuiBulan(string $bulan, ?int $idPerusahaan = null): array
    {
        $builder = $this->db->table('ketidakhadiran k')
            ->select('k.*, pg.nama, pg.id_perusahaan')
            ->join('pegawai pg', 'pg.id = k.id_pegawai')
            ->like('k.tanggal', $bulan, 'after')
            ->where('k.status_pengajuan', 'Disetujui');

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->get()->getResultArray();
    }
}
