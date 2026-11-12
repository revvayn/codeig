<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuperadminDanPlant extends Migration
{
    public function up()
    {
        // Plant/lokasi presensi sekarang dimiliki oleh perusahaan (bisa > 1 plant per perusahaan).
        if (! $this->db->fieldExists('id_perusahaan', 'lokasi_presensi')) {
            $this->forge->addColumn('lokasi_presensi', [
                'id_perusahaan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id',
                ],
            ]);
        }

        $this->db->query('UPDATE `lokasi_presensi` SET `id_perusahaan` = 1 WHERE `id_perusahaan` IS NULL');

        // Akun superadmin/admin boleh tidak terikat ke data pegawai.
        $this->db->query('ALTER TABLE `users` MODIFY `id_pegawai` INT(11) UNSIGNED NULL');

        // Buat akun superadmin default (password: superadmin).
        $hash = password_hash('superadmin', PASSWORD_BCRYPT);
        $this->db->table('users')->insert([
            'id_perusahaan' => 1,
            'id_pegawai'    => null,
            'username'      => 'superadmin',
            'password'      => $hash,
            'status'        => 'Aktif',
            'role'          => 'Superadmin',
        ]);
    }

    public function down()
    {
        $this->db->table('users')->where('username', 'superadmin')->delete();

        $this->db->query('ALTER TABLE `users` MODIFY `id_pegawai` INT(11) UNSIGNED NOT NULL');

        if ($this->db->fieldExists('id_perusahaan', 'lokasi_presensi')) {
            $this->forge->dropColumn('lokasi_presensi', 'id_perusahaan');
        }
    }
}
