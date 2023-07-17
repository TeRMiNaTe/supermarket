<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDiscount;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductDiscountController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return response()->view('discounts/list', [
			'discounts' => ProductDiscount::with('product')->get(),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$products = Product::whereDoesntHave('discount')->get();

		if (empty($products)) {
			return redirect()->route('discounts.index')->withErrors('There are no available products to discount.');
		}

		return response()->view('discounts/create', [
			'products' => Product::whereDoesntHave('discount')->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'product_id' => 'required|exists:products,id|unique:product_discounts,product_id',
			'quantity'   => 'required|integer',
			'price'      => [
				'required',
				'integer',
				function (string $attribute, mixed $value, Closure $fail) use ($request) {
					if ($value >= Product::find($request->input('product_id'))->price * $request->input('quantity')) {
						$fail("The amount you have selected must be lower than the individual cost of the products!");
					}
				},
			]
		], [
			'product_id.exists' => 'The product you have selected does not exist',
			'product_id.unique' => 'There is already a discount configured for this product',
		]);

		ProductDiscount::create($request->only(['product_id', 'quantity', 'price']));

		return redirect()->route('discounts.index')->with('status', 'Discount successfully created.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ProductDiscount $discount)
	{
		// Not implemented
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ProductDiscount $discount)
	{
		return response()->view('discounts/edit', [
			'discount' => $discount,
			'products' => Product::whereDoesntHave('discount')->orWhere('id', $discount->product_id)->get(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(ProductDiscount $discount, Request $request)
	{
		$request->validate([
			'product_id' => [
				'required',
				'exists:products,id',
				Rule::unique('product_discounts')->ignore($discount->product->id, 'product_id'),

			],
			'quantity'   => 'required|integer',
			'price'      => [
				'required',
				'integer',
				function (string $attribute, mixed $value, Closure $fail) use ($request) {
					if ($value >= Product::find($request->input('product_id'))->price * $request->input('quantity')) {
						$fail("The amount you have selected must be lower than the individual cost of the products!");
					}
				},
			]
		], [
			'product_id.exists' => 'The product you have selected does not exist',
			'product_id.unique' => 'There is already a discount configured for this product',
		]);

		$discount->update($request->only(['product_id', 'quantity', 'price']));

		return redirect()->route('discounts.index')->with('status', 'Discount successfully updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ProductDiscount $discount)
	{
		$discount->delete();

		return redirect()->back()->with('status', 'Discount deleted.');
	}
}
