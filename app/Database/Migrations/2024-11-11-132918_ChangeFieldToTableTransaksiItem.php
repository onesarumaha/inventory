<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeFieldToTableTransaksiItem extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('transaksi_item', [
            'price' => [
                'type'       => 'INT', 
                'constraint' => 30,    
                'null'       => false, 
            ],

            'total' => [
                'type'       => 'INT', 
                'constraint' => 30,    
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('transaksi_item', [
            'price' => [
                'type'       => 'DECIMAL', 
                'constraint' => '15,2',   
                'null'       => false,
            ],
            'total' => [
                'type'       => 'DECIMAL', 
                'constraint' => '15,2',   
                'null'       => false,
            ],
        ]);
    }
}
