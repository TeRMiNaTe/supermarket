<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderProduct extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'product_id',
		'price',
		'original_price',
	];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The order that this product is part of
	 */
	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Product discounts for buying in bulk
	 */
	public function discount(): HasOne
	{
		return $this->hasOne(ProductDiscount::class, 'product_id', 'product_id');
	}

	/**
	 * The related product
	 */
	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	/**
	 * Check if the product is discounted
	 *
	 * @return bool
	 */
	public function isDiscounted(): bool
	{
		return $this->price < $this->original_price;
	}
}
