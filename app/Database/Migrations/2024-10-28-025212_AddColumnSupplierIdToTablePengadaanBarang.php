<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnSupplierIdToTablePengadaanBarang extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengadaan_barang', [
            'supplier_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'after' => 'price', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengadaan_barang', 'supplier_id');
    }
}
