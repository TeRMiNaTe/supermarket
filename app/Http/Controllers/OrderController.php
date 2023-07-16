<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
	/**
	 * Display a product order
	 */
	public function index(int $id): View
	{
		return view('order', [
			'order' => Order::with('products')->findOrFail($id),
		]);
	}
}
