<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class Customer extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); 
        
        for ($i = 0; $i < 100; $i++) { 
            $data = [
                'name'    => $faker->name,
                'email'   => $faker->email,
                'address' => $faker->address,
                'phone'   => $faker->phoneNumber,
            ];

            $this->db->table('customer')->insert($data);
        }
    }
}
