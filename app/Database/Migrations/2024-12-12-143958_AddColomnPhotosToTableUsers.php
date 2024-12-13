<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColomnPhotosToTableUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'photos' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '100',
                'after' => 'active', 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'photos');
    }
}
