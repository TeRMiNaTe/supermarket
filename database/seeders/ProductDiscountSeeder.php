<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDiscountSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		if ($product = Product::where('SKU', 'A')->first()) {
			ProductDiscount::factory()->for($product)->create([
				'quantity' => 3,
				'price' => 130,
			]);
		}

		if ($product = Product::where('SKU', 'B')->first()) {
			ProductDiscount::factory()->for($product)->create([
				'quantity' => 2,
				'price' => 45,
			]);
		}
	}
}
