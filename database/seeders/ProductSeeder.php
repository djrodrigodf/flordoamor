<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            // Resinas e Inflorescências
            [
                'name' => 'Resina Medicinal',
                'description' => 'Derivada de plantas',
                'category' => 'Resinas e Inflorescências',
                'size' => '30g',
                'stock_quantity' => 100,
                'unit_price' => 50.00,
            ],
            [
                'name' => 'Flores Louva Deusa',
                'description' => 'Inflorescência medicinal',
                'category' => 'Resinas e Inflorescências',
                'size' => '30g',
                'stock_quantity' => 80,
                'unit_price' => 120.00,
            ],
            [
                'name' => 'Flores Maria Redonda',
                'description' => 'Inflorescência relaxante',
                'category' => 'Resinas e Inflorescências',
                'size' => '30g',
                'stock_quantity' => 50,
                'unit_price' => 100.00,
            ],
            [
                'name' => 'Flores Pachamama',
                'description' => 'Inflorescência com alto teor de CBD',
                'category' => 'Resinas e Inflorescências',
                'size' => '30g',
                'stock_quantity' => 40,
                'unit_price' => 130.00,
            ],

            // Óleos THC - Espectro Amplo
            [
                'name' => 'Óleo de THC 3%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos THC - Espectro Amplo',
                'size' => '5ml',
                'stock_quantity' => 60,
                'unit_price' => 120.00,
            ],
            [
                'name' => 'Óleo de THC 3%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos THC - Espectro Amplo',
                'size' => '15ml',
                'stock_quantity' => 50,
                'unit_price' => 200.00,
            ],
            [
                'name' => 'Óleo de THC 5%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos THC - Espectro Amplo',
                'size' => '5ml',
                'stock_quantity' => 70,
                'unit_price' => 180.00,
            ],
            [
                'name' => 'Óleo de THC 10%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos THC - Espectro Amplo',
                'size' => '5ml',
                'stock_quantity' => 30,
                'unit_price' => 300.00,
            ],

            // Óleos CBD - Espectro Amplo
            [
                'name' => 'Óleo de CBD 3%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos CBD - Espectro Amplo',
                'size' => '5ml',
                'stock_quantity' => 90,
                'unit_price' => 100.00,
            ],
            [
                'name' => 'Óleo de CBD 5%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos CBD - Espectro Amplo',
                'size' => '15ml',
                'stock_quantity' => 40,
                'unit_price' => 200.00,
            ],
            [
                'name' => 'Óleo de CBD 10%',
                'description' => 'Espectro Amplo',
                'category' => 'Óleos CBD - Espectro Amplo',
                'size' => '5ml',
                'stock_quantity' => 20,
                'unit_price' => 400.00,
            ],

            // Complementares
            [
                'name' => 'Pomada Bálsamo Hidratante',
                'description' => 'Uso medicinal, hidratante',
                'category' => 'Complementares',
                'size' => '60ml',
                'stock_quantity' => 100,
                'unit_price' => 70.00,
            ],
            [
                'name' => 'Shiva sakti',
                'description' => 'Lubrificante íntimo',
                'category' => 'Complementares',
                'size' => '30ml',
                'stock_quantity' => 80,
                'unit_price' => 90.00,
            ],
        ]);
    }
}
