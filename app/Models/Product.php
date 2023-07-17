<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'SKU',
		'price',
	];

	/**
	 * Product discounts for buying in bulk
	 */
	public function discount(): HasOne
	{
		return $this->hasOne(ProductDiscount::class);
	}

	/**
	 * Orders that contan this product
	 */
	public function orders(): HasManyThrough
	{
		return $this->hasManyThrough(Order::class, OrderProduct::class, 'product_id', 'id', 'id', 'order_id');
	}
}
