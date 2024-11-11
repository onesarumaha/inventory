<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldUserIdToTableTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaksi', [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'after' => 'total_price', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi', 'user_id');
    }
}
