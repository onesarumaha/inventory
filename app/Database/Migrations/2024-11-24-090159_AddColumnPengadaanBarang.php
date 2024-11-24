<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnPengadaanBarang extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengadaan_barang', [
            'quantity_real' => [
                'type' => 'INT',
                'constraint' => 50,
                'null' => true,
                'after' => 'upload', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengadaan_barang', 'quantity_real');
        
    }
}
