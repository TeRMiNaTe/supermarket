<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return response()->view('products/list', [
			'products' => Product::all(),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return response()->view('products/create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'SKU' => 'required|string|alpha:ascii|uppercase|unique:products,SKU',
			'price' => 'required|integer'
		], [
			'SKU.unique' => 'A product with this SKU already exists.',
		]);

		Product::create($request->only(['SKU', 'price']));

		return redirect()->route('products.index')->with('status', 'Product successfully created.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Product $product)
	{
		// Not implemented
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Product $product)
	{
		return response()->view('products/edit', [
			'product' => $product,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Product $product, Request $request)
	{
		$request->validate([
			'SKU' => [
				'required',
				'string',
				'alpha:ascii',
				'uppercase',
				Rule::unique('products')->ignore($product->SKU, 'SKU'),
			],
			'price' => 'required|integer'
		], [
			'SKU.unique' => 'A product with this SKU already exists.',
		]);

		$product->update($request->only(['SKU', 'price']));

		return redirect()->route('products.index')->with('status', 'Product successfully updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Product $product)
	{
		if ($product->orders()->count()) {
			return redirect()->back()->withErrors('Cannot delete a product that exists in an order.');
		}

		$product->delete();

		return redirect()->back()->with('status', 'Product deleted.');
	}
}
