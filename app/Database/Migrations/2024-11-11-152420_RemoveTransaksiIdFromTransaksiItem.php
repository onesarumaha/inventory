<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTransaksiIdFromTransaksiItem extends Migration
{
    public function up()
    {
        $this->forge->dropTable('transaksi_item');
    }

    public function down()
    {
        //
    }
}
