<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('order_product_discounts', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('order_id');
			$table->unsignedInteger('product_id');
			$table->unsignedInteger('quantity');
			$table->unsignedInteger('price');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('order_product_discounts');
	}
};
