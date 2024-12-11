<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToTableLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan', 'created_at');
        $this->forge->dropColumn('laporan', 'updated_at');
        $this->forge->dropColumn('laporan', 'deleted_at');
    }
}
