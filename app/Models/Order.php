<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
	use HasFactory;

	/**
	 * The products contained within the order
	 */
	public function products(): HasMany
	{
		return $this->hasMany(OrderProduct::class);
	}
}
