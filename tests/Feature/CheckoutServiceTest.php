<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
	/**
	 * Check if the created order exists in the DB
	 */
	public function testOrderIsCreated(): void
	{
		$checkout = $this->app->get(CheckoutService::class);

		$order = $checkout->createOrder();

		$this->assertInstanceOf(Order::class, $order);

		$this->assertModelExists($order);
	}

	/**
	 * Check if products can be added to the order
	 */
	public function testProductsCanBeAddedToOrder(): void
	{
		$order = Order::factory()->create();

		$checkout = $this->app->get(CheckoutService::class);

		$checkout->addProductToOrder($order, Product::factory()->create()->id);

		$this->assertEquals(1, $order->products()->count());

		$checkout->addProductsToOrder($order, Product::factory(3)->create()->pluck('id')->all());

		$this->assertEquals(4, $order->products()->count());

		$checkout->addProductToOrder($order, Product::factory()->create()->id);

		$this->assertEquals(5, $order->products()->count());
	}

	/**
	 * Check if the order total is updated properly
	 */
	public function testOrderTotalIsUpdated(): void
	{
		$order = Order::factory()->create();
		$products = Product::factory(5)->create();

		$order_total = $products->sum('price');
		$single_product = $products->shift();

		$checkout = $this->app->get(CheckoutService::class);

		$checkout->addProductToOrder($order, $single_product->id);

		$this->assertEquals($order->total, $single_product->price);

		$checkout->addProductsToOrder($order, $products->pluck('id')->all());

		$this->assertEquals($order->total, $order_total);
	}

}
