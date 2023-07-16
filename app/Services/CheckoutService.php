<?php

namespace App\Services;

use App\Models\{
	Order,
	Product,
	OrderProduct,
};
use Illuminate\Support\Collection;

class CheckoutService
{
	/**
	 * Create a new order
	 *
	 * @return Order
	 */
	public function createOrder(): Order
	{
		return Order::factory()->create(['total' => 0]);
	}

	/**
	 * Add a single product to an existing order
	 *
	 * @param Order $order
	 * @param int   $product_id
	 */
	public function addProductToOrder(Order $order, int $product_id): void
	{
		$this->createOrderProduct($order, $product_id);

		$this->calculateOrderTotal($order);
	}

	/**
	 * Add multiple products to an existing order
	 *
	 * @param Order $order
	 * @param int[] $products
	 */
	public function addProductsToOrder(Order $order, array $products): void
	{
		array_map(fn(int $product_id) => $this->createOrderProduct($order, $product_id), $products);

		$this->calculateOrderTotal($order);
	}

	/**
	 * Recalculates the order total
	 *
	 * @param  Order  $order
	 * @return void
	 */
	public function calculateOrderTotal(Order $order): void
	{
		$order->total = $order->products()->sum('price');
		$order->save();
	}

	/**
	 * Create a new product for the order
	 *
	 * @param  Order  $order
	 * @param  int    $product_id
	 * @return OrderProduct
	 */
	protected function createOrderProduct(Order $order, int $product_id): OrderProduct
	{
		$product = Product::find($product_id);

		return $order->products()->create([
			'product_id' => $product_id,
			'price' => $product->price,
			'original_price' => $product->price,
		]);
	}
}
