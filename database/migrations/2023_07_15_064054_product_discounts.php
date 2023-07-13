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
		Schema::create('product_discounts', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('product_id')->unique();
			$table->unsignedInteger('quantity');
			$table->unsignedInteger('price');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('product_discounts');
	}
};
