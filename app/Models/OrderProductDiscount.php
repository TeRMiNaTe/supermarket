<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProductDiscount extends Model
{
	use HasFactory;

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The order that this discount is part of
	 */
	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Check if the discount can be applied to a product in the order
	 *
	 * @param  OrderProduct $product The product for which to check
	 * @return bool
	 */
	public function canBeAppliedTo(OrderProduct $product): bool
	{
		return $this->quantity > 0 && $this->product_id === $product->product_id && !$product->isDiscounted();
	}

	/**
	 * Apply the discount to a product in the order
	 *
	 * @param  OrderProduct $product
	 * @return OrderProduct          The updated product instance containing the discounted price
	 */
	public function applyTo(OrderProduct $product): OrderProduct
	{
		$product->price = $this->calculateProductDiscountedPrice();

		$this->price -= $product->price;
		$this->quantity -= 1;

		return $product;
	}

	/**
	 * Calculate the discount price for an individual product
	 * Since it's not guaranteed that the discount can be evenly distributed, we use rounding
	 * The rounding excess will always be applied to the last product (as we divide by 1)
	 *
	 * @return int The discounted price of the product
	 */
	protected function calculateProductDiscountedPrice(): int
	{
		return floor($this->price / $this->quantity);
	}
}
