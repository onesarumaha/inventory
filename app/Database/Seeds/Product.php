<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class Product extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); 
        
        for ($i = 0; $i < 100; $i++) { 
            $data = [
                'name'        => $faker->word,
                'sku'        => $faker->randomFloat(2, 1000, 100000), 
                'description' => $faker->sentence,
                'price'       => $faker->randomFloat(2, 1000, 100000), 
                'stock'       => $faker->numberBetween(10, 100), 
            ];

            $this->db->table('product')->insert($data);
        }
    }
}
