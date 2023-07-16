<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
	/**
	 * Display the checkout form
	 */
	public function index(Request $request): View
	{
		return view('checkout', [
			'products' => Product::all(),
		]);
	}
}
