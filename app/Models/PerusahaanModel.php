<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table         = 'perusahaan';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nama_perusahaan',
        'alamat',
        'telepon',
        'email',
        'status',
    ];
    protected $useTimestamps = false;

    public function aktif()
    {
        return $this->where('status', 'Aktif')->orderBy('nama_perusahaan', 'ASC');
    }
}
