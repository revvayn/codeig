<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PresensiNullable extends Migration
{
    public function up()
    {
        // Kolom presensi pulang harus boleh kosong sampai pegawai melakukan presensi pulang.
        $this->db->query('ALTER TABLE `presensi` MODIFY `tanggal_keluar` DATE NULL');
        $this->db->query('ALTER TABLE `presensi` MODIFY `jam_keluar` TIME NULL');
        $this->db->query('ALTER TABLE `presensi` MODIFY `foto_keluar` VARCHAR(225) NULL');
    }

    public function down()
    {
        $this->db->query("UPDATE `presensi` SET `tanggal_keluar` = '1970-01-01' WHERE `tanggal_keluar` IS NULL");
        $this->db->query("UPDATE `presensi` SET `jam_keluar` = '00:00:00' WHERE `jam_keluar` IS NULL");
        $this->db->query("UPDATE `presensi` SET `foto_keluar` = '' WHERE `foto_keluar` IS NULL");

        $this->db->query('ALTER TABLE `presensi` MODIFY `tanggal_keluar` DATE NOT NULL');
        $this->db->query('ALTER TABLE `presensi` MODIFY `jam_keluar` TIME NOT NULL');
        $this->db->query('ALTER TABLE `presensi` MODIFY `foto_keluar` VARCHAR(225) NOT NULL');
    }
}
