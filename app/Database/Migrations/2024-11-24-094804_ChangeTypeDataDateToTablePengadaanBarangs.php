<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeTypeDataDateToTablePengadaanBarangs extends Migration
{
    public function up()
    {
        
        $this->forge->modifyColumn('pengadaan_barang', [
            'date' => [
                'type' => 'DATETIME',
                'null' => true, 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('pengadaan_barang', [
            'date' => [
                'type' => 'DATE',
                'null' => true, 
            ],
        ]);
    }
}
