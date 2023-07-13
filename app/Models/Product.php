<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
	use HasFactory;

	/**
	 * Product discounts for buying in bulk
	 */
	public function discount(): HasOne
	{
		return $this->hasOne(ProductDiscount::class);
	}
}
