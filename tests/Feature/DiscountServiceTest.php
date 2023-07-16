<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Services\ProductDiscountService;
use Tests\TestCase;

class DiscountServiceTest extends TestCase
{
	/**
	 * Test if discounts are correctly applied to orderss
	 * The configuration is separated from the seeder as product prices & discounts are subject ot change
	 */
	public function testDiscountIsApplied(): void
	{
		ProductDiscount::factory()->for(Product::factory()->create([
			'SKU' => 'A',
			'price' => 50,
		]))->create([
			'quantity' => 3,
			'price' => 130,
		]);

		ProductDiscount::factory()->for(Product::factory()->create([
			'SKU' => 'B',
			'price' => 30,
		]))->create([
			'quantity' => 2,
			'price' => 45,
		]);

		Product::factory()->create([
			'SKU' => 'C',
			'price' => 20,
		]);

		Product::factory()->create([
			'SKU' => 'D',
			'price' => 10,
		]);

		foreach ([
			'A'      => 50,
			'AB'     => 80,
			'CDBA'   => 110,
			'AA'     => 100,
			'AAA'    => 130,
			'AAAA'   => 180,
			'AAAAA'  => 230,
			'AAAAAA' => 260,
			'AAAB'   => 160,
			'AAABB'  => 175,
			'AAABBD' => 185,
			'DABABA' => 185,
		] as $product_skus => $expected_order_price) {
			$order = Order::factory()->create();

			foreach (str_split($product_skus) as $product_sku) {
				$product = Product::where('SKU', $product_sku)->first();

				$order->products()->create([
					'product_id' => $product->id,
					'price' => $product->price,
					'original_price' => $product->price,
				]);
			}

			$discount_service = $this->app->makeWith(ProductDiscountService::class, ['order' => $order])->applyProductDiscounts();

			$this->assertEquals($order->total, $expected_order_price);
		}
	}

}
