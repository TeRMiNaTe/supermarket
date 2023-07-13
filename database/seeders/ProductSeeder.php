<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Product::factory()->create([
			'SKU' => 'A',
			'price' => 50,
		]);

		Product::factory()->create([
			'SKU' => 'B',
			'price' => 30,
		]);

		Product::factory()->create([
			'SKU' => 'C',
			'price' => 20,
		]);

		Product::factory()->create([
			'SKU' => 'D',
			'price' => 10,
		]);
	}
}
