<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnumStatusToTablePengadaanBarangs extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('pengadaan_barang', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1', '2', '3', '4', '5', '6'],
                'default' => '0', 

            ],
        ]);
    }

    public function down()
    {
        //
    }
}
