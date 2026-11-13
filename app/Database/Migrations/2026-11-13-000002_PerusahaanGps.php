<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PerusahaanGps extends Migration
{
    public function up()
    {
        $fields = [
            'latitude'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'email'],
            'longitude'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'latitude'],
            'radius'     => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'after' => 'longitude'],
            'zona_waktu' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true, 'after' => 'radius'],
            'jam_masuk'  => ['type' => 'TIME', 'null' => true, 'after' => 'zona_waktu'],
            'jam_pulang' => ['type' => 'TIME', 'null' => true, 'after' => 'jam_masuk'],
        ];

        foreach ($fields as $name => $def) {
            if (! $this->db->fieldExists($name, 'perusahaan')) {
                $this->forge->addColumn('perusahaan', [$name => $def]);
            }
        }

        // Seed company 1 with default GPS (existing plant 1 coords).
        $this->db->query("UPDATE `perusahaan` SET `latitude`='-7.101301356164437', `longitude`='109.9167435556062', `radius`=20, `zona_waktu`='WIB', `jam_masuk`='14:38:00', `jam_pulang`='20:44:00' WHERE `id`=1 AND `latitude` IS NULL");
    }

    public function down()
    {
        foreach (['jam_pulang','jam_masuk','zona_waktu','radius','longitude','latitude'] as $col) {
            if ($this->db->fieldExists($col, 'perusahaan')) {
                $this->forge->dropColumn('perusahaan', $col);
            }
        }
    }
}
