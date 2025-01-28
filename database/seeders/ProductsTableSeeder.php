<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample product data
        $products = [
            [
                'name' => 'Wireless Mouse',
                'description' => 'A sleek and ergonomic wireless mouse.',
                'price' => 19.99,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bluetooth Headphones',
                'description' => 'High-quality sound with noise cancellation.',
                'price' => 49.99,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB-C Charger',
                'description' => 'Fast charging USB-C charger.',
                'price' => 14.99,
                'stock' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Keyboard',
                'description' => 'Mechanical keyboard with RGB lighting.',
                'price' => 79.99,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HD Webcam',
                'description' => '1080p webcam for video conferencing.',
                'price' => 39.99,
                'stock' => 70,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into the products table
        DB::table('products')->insert($products);
    }
}
