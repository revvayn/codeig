<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table         = 'pegawai';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id_perusahaan',
        'nip',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_handphone',
        'jabatan',
        'lokasi_presensi',
        'foto',
    ];

    public function byPerusahaan(?int $idPerusahaan = null)
    {
        $builder = $this->db->table('pegawai pg')
            ->select('pg.*, u.username, u.role, u.status, pr.nama_perusahaan, lp.nama_lokasi')
            ->join('users u', 'u.id_pegawai = pg.id', 'left')
            ->join('perusahaan pr', 'pr.id = pg.id_perusahaan', 'left')
            ->join('lokasi_presensi lp', 'lp.id = pg.lokasi_presensi', 'left')
            ->orderBy('pg.nama', 'ASC');

        // Data Pegawai hanya berisi pegawai; akun ber-role Admin dikelola di menu Data Admin (Superadmin).
        $builder->groupStart()
            ->where('u.role', 'Pegawai')
            ->orWhere('u.id', null)
            ->groupEnd();

        if ($idPerusahaan !== null) {
            $builder->where('pg.id_perusahaan', $idPerusahaan);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Jumlah pegawai (tanpa akun Admin) pada satu perusahaan.
     */
    public function jumlahPegawaiPerusahaan(int $idPerusahaan): int
    {
        return $this->db->table('pegawai pg')
            ->join('users u', 'u.id_pegawai = pg.id', 'left')
            ->where('pg.id_perusahaan', $idPerusahaan)
            ->groupStart()
                ->where('u.role', 'Pegawai')
                ->orWhere('u.id', null)
            ->groupEnd()
            ->countAllResults();
    }

    public function DetailPegawai($id = false)
    {
        return $this->db->table('pegawai pg')
            ->select('pg.*, u.username, u.status, u.role, pr.nama_perusahaan, lp.nama_lokasi, lp.zona_waktu')
            ->join('users u', 'u.id_pegawai = pg.id', 'left')
            ->join('perusahaan pr', 'pr.id = pg.id_perusahaan', 'left')
            ->join('lokasi_presensi lp', 'lp.id = pg.lokasi_presensi', 'left')
            ->where('pg.id', $id)
            ->get()
            ->getRowArray();
    }

    public function EditPegawai($id = false)
    {
        return $this->db->table('pegawai pg')
            ->select('pg.*, u.username, u.password, u.status, u.role, u.id_perusahaan as user_perusahaan')
            ->join('users u', 'u.id_pegawai = pg.id', 'left')
            ->where('pg.id', $id)
            ->get()
            ->getRowArray();
    }

    public function jumlahPerusahaan(int $idPerusahaan): int
    {
        return $this->where('id_perusahaan', $idPerusahaan)->countAllResults();
    }
}
