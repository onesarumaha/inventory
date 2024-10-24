<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class Supplier extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); 
        
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'name'    => $faker->company,
                'address' => $faker->address,
                'phone'   => $faker->phoneNumber,
                'email'   => $faker->companyEmail,
            ];

            $this->db->table('supplier')->insert($data);
        }
    }
}
