<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableLaporanStock extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['-', 'in', 'out'], 
                'null'       => false,
                'default'    => '-', 
            ],
        ]);

    $this->forge->addKey('id', true);

    $this->forge->addForeignKey('product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

    $this->forge->createTable('laporan');
    
    }

    public function down()
    {
        $this->forge->dropTable('laporan');
        
    }
}
