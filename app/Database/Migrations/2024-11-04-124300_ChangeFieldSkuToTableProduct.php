<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeFieldSkuToTableProduct extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('product', [
            'sku' => [
                'name' => 'volume',  
                'type' => 'VARCHAR',
                'constraint' => 255, 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('product', [
            'volume' => [
                'name' => 'sku',  
                'type' => 'VARCHAR',
                'constraint' => 255, 
            ],
        ]);
    }
}
