<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Password;

class User extends Seeder
{
    public function run()
    {
        $password = Password::hash('123456');

        $users = [
            [
                'username' => 'admin',
                'email'    => 'admin@example.com',
                'password_hash' => $password,
                'role'     => 'admin',
                'active'     => 1,
                'created_at'  => date('Y-m-d H:i:s') 
            ],
            [
                'username' => 'owner',
                'email'    => 'owner@example.com',
                'password_hash' => $password,
                'role'     => 'owner',
                'active'     => 1,
                'created_at'  => date('Y-m-d H:i:s') 

            ],
        ];
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
