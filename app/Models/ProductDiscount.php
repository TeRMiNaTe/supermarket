<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductDiscount extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'product_id',
		'quantity',
		'price',
	];

	/**
	 * The product to which the discount can be applied
	 */
	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	/**
	 * The ordered product to which the discount has been applied
	 */
	public function orderProducts(): BelongsToMany
	{
		return $this->belongsToMany(OrderProduct::class);
	}
}
