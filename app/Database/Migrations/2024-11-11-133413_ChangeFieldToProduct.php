<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeFieldToProduct extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('product', [
            'price' => [
                'type'       => 'INT', 
                'constraint' => 30,    
                'null'       => false, 
            ],

            
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('product', [
            'price' => [
                'type'       => 'DECIMAL', 
                'constraint' => '15,2',   
                'null'       => false,
            ],
           
        ]);
    }
}
