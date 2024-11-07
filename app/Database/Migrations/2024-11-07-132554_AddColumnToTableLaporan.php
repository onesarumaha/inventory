<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToTableLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan', [
            'parant_id' => [
                'type' => 'INT',
                'constraint' => 50,
                'null' => false,
                'after' => 'id', 
            ],
            'from' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        
    }

    public function down()
    {
        $this->forge->dropColumn('laporan', 'parent_id');
        $this->forge->dropColumn('laporan', 'from');
    }
}
