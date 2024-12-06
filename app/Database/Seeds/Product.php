<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class Product extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); 

        $data = [
            [
                'name' => 'Enduro Gear',
                'volume' => '0.12 Liter',
                'price' => 16500,
                'stock' => 50,
                'description' => '24x0,12',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran Super Motor',
                'volume' => '0,8 Liter',
                'price' => 41000,
                'stock' => 50,
                'description' => '24x0,8',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Enduro 4T 0,8',
                'volume' => '0,8 Liter',
                'price' => 50000,
                'stock' => 50,
                'description' => '6x0,8',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Enduro Matic 0,8',
                'volume' => '0,8 Liter',
                'price' => 53000,
                'stock' => 50,
                'description' => '6x0,8',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Enduro Matic G',
                'volume' => '0,8 Liter',
                'price' => 45000,
                'stock' => 50,
                'description' => '6x0,8',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran 40',
                'volume' => '1 Liter',
                'price' => 49000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran B40',
                'volume' => '1 Liter',
                'price' => 51000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran Super SG',
                'volume' => '1 Liter',
                'price' => 53000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '2 Tak Super',
                'volume' => '1 Liter',
                'price' => 55000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '2 Tak OB',
                'volume' => '1 Liter',
                'price' => 50000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Prima XP 20w-50',
                'volume' => '1 Liter',
                'price' => 54000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Prima XP 10w-40',
                'volume' => '1 Liter',
                'price' => 68000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SC',
                'volume' => '1 Liter',
                'price' => 57000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SX',
                'volume' => '1 Liter',
                'price' => 60000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Endur0 10w-40',
                'volume' => '1 Liter',
                'price' => 70000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Syn 10w-40',
                'volume' => '1 Liter',
                'price' => 87000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Diesel 15w-40',
                'volume' => '1 Liter',
                'price' => 85000,
                'stock' => 50,
                'description' => '20x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Gold 5w-30',
                'volume' => '1 Liter',
                'price' => 152000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Transmisi ATF ',
                'volume' => '1 Liter',
                'price' => 152000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Air Accu ',
                'volume' => '1 Liter',
                'price' => 7000,
                'stock' => 50,
                'description' => '6x1',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Eco 5w-30',
                'volume' => '3,5 Liter',
                'price' => 280000,
                'stock' => 50,
                'description' => '6x3,5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Eco 0w-21',
                'volume' => '3,5 Liter',
                'price' => 265000,
                'stock' => 50,
                'description' => '6x3,5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran Super SG',
                'volume' => '4 Liter',
                'price' => 200000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran B40',
                'volume' => '4 Liter',
                'price' => 188000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran 40',
                'volume' => '4 Liter',
                'price' => 188000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Prima XP 20w-50',
                'volume' => '4 Liter',
                'price' => 203000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Prima XP 10w-40',
                'volume' => '4 Liter',
                'price' => 261000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rored EPA 90',
                'volume' => '4 Liter',
                'price' => 215000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rored EPA 140',
                'volume' => '4 Liter',
                'price' => 225000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rored HDA 90',
                'volume' => '4 Liter',
                'price' => 239000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rored HDA 140',
                'volume' => '4 Liter',
                'price' => 245000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Diesel 15w-40',
                'volume' => '4 Liter',
                'price' => 317000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fastron Syn 10w-40',
                'volume' => '4 Liter',
                'price' => 341000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SX',
                'volume' => '4 Liter',
                'price' => 217000,
                'stock' => 50,
                'description' => '6x4',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran B40',
                'volume' => '5 Liter',
                'price' => 225000,
                'stock' => 50,
                'description' => '4x5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SAE 40',
                'volume' => '5 Liter',
                'price' => 237000,
                'stock' => 50,
                'description' => '4x5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SC',
                'volume' => '5 Liter',
                'price' => 264000,
                'stock' => 50,
                'description' => '4x5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Coolant',
                'volume' => '5 Liter',
                'price' => 50000,
                'stock' => 50,
                'description' => '4x5',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Mesran B40',
                'volume' => '10 Liter',
                'price' => 443000,
                'stock' => 50,
                'description' => '2x10',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SAE 40',
                'volume' => '10 Liter',
                'price' => 458000,
                'stock' => 50,
                'description' => '2x10',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SC',
                'volume' => '10 Liter',
                'price' => 521000,
                'stock' => 50,
                'description' => '2x10',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Meditran SX',
                'volume' => '10 Liter',
                'price' => 535000,
                'stock' => 50,
                'description' => '2x10',
                'created_at' => $faker->dateTime('now')->format('Y-m-d H:i:s'),
            ],
            

      
        ];

        $this->db->table('product')->insertBatch($data);
    }
}
