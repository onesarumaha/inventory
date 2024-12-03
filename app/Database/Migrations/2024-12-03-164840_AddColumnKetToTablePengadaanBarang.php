<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnKetToTablePengadaanBarang extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengadaan_barang', [
            'ket' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'quantity_real', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengadaan_barang', 'ket');
    }
}
