<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perusahaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_perusahaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Aktif',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('perusahaan', true);

        if (! $this->db->fieldExists('id_perusahaan', 'users')) {
            $this->forge->addColumn('users', [
                'id_perusahaan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'default'    => 1,
                ],
            ]);
        }

        if (! $this->db->fieldExists('id_perusahaan', 'pegawai')) {
            $this->forge->addColumn('pegawai', [
                'id_perusahaan' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'default'    => 1,
                ],
            ]);
        }

        $builder = $this->db->table('perusahaan');
        if ($builder->countAllResults() === 0) {
            $builder->insert([
                'nama_perusahaan' => 'PT. Nusantara Jaya',
                'alamat'          => 'Jl. Merdeka No. 1, Semarang',
                'telepon'         => '024-1234567',
                'email'           => 'admin@nusantarajaya.co.id',
                'status'          => 'Aktif',
            ]);
        }

        $this->db->table('users')->update(['id_perusahaan' => 1]);
        $this->db->table('pegawai')->update(['id_perusahaan' => 1]);
    }

    public function down()
    {
        if ($this->db->fieldExists('id_perusahaan', 'users')) {
            $this->forge->dropColumn('users', 'id_perusahaan');
        }
        if ($this->db->fieldExists('id_perusahaan', 'pegawai')) {
            $this->forge->dropColumn('pegawai', 'id_perusahaan');
        }

        $this->forge->dropTable('perusahaan', true);
    }
}
