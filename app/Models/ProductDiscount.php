<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDiscount extends Model
{
	use HasFactory;

	/**
	 * The product to which the discount can be applied
	 */
	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

}
