<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnOmsetToTableLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan', [
            'omset' => [
                'type' => 'INT',
                'constraint' => 50,
                'null' => false,
                'after' => 'quantity', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan', 'omset');
    }
}
