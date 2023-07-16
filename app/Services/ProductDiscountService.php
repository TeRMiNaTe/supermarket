<?php

namespace App\Services;

use App\Models\{
	Order,
	OrderProduct,
	OrderProductDiscount,
	ProductDiscount,
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductDiscountService
{
	/**
	 * Contains the count of each product in the order grouped by ID
	 *
	 * @var array Format: [int $product_id => int $count]
	 */
	protected array $product_count;

	/**
	 * This service works directly with an order instance
	 * We load the order and count the products in it
	 *
	 * @param Order $order
	 */
	public function __construct(
		protected Order $order,
	) {
		$this->product_count = $this->countOrderProducts();
	}

	/**
	 * Count the products in the order
	 *
	 * @return array
	 */
	protected function countOrderProducts(): array
	{
		return $this->order->products->countBy(fn(OrderProduct $product) => $product->product_id)->toArray();
	}

	/**
	 * Apply any appplicable product discounts to the order
	 *
	 * @return void
	 */
	public function applyProductDiscounts(): void
	{
		$discounts = $this->createOrderProductDiscounts();

		foreach ($discounts as $discount) {
			$this->applyDiscountToProducts($discount);
		}

		app()->make(CheckoutService::class)->calculateOrderTotal($this->order);
	}

	/**
	 * Find applicable product discounts and apply them to the order
	 *
	 * @return Collection List of OrderProductDiscount instances
	 */
	protected function createOrderProductDiscounts(): Collection
	{
		$discounts = collect();

		$this->findApplicableDiscounts()->each(function(ProductDiscount $discount) use (&$discounts) {
			$discount_applications = intdiv($this->product_count[$discount->product_id], $discount->quantity);

			$discounts = $discounts->merge(
				OrderProductDiscount::factory()
					->count($discount_applications)
					->for($this->order)
					->create($discount->only(['product_id', 'quantity', 'price']))
			);
		});

		return $discounts;
	}

	/**
	 * Finds product discounts that can be applied to the order
	 *
	 * @return Collection List of ProductDiscount instances
	 */
	protected function findApplicableDiscounts(): Collection
	{
		return ProductDiscount::where(function (Builder $query) {
			foreach ($this->product_count as $product_id => $quantity) {
				$query->orWhere(function (Builder $query2) use ($quantity, $product_id) {
					$query2->where('product_id', $product_id)
						  ->where('quantity', '<=', $quantity);
				});
			}
		})->get();
	}

	/**
	 * Apply a discount to the order's products
	 *
	 * @param  OrderProductDiscount $discount
	 * @return void
	 */
	protected function applyDiscountToProducts(OrderProductDiscount $discount): void
	{
		foreach ($this->order->products as &$product) {
			if ($discount->canBeAppliedTo($product)) {
				$product = $discount->applyTo($product);
				$product->save();
			}
		}
	}
}
