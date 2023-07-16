<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Services\ProductDiscountService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
	/**
	 * Process the product order by:
	 *   1. Creating the order
	 *   2. Adding the products to the order
	 *   3. Applying product discounts
	 *
	 * @param  Request          $request
	 * @param  CheckoutService  $checkout
	 * @return RedirectResponse
	 */
	public function index(Request $request, CheckoutService $checkout): RedirectResponse
	{
		$request->validate([
			'products' => 'required|array',
			'products.*' => 'exists:products,id'
		], [
			'products.*.exists' => 'The product you have selected does not exist.',
		]);

		$order = $checkout->createOrder();

		$checkout->addProductsToOrder($order, $request->input('products'));

		app()->makeWith(ProductDiscountService::class, ['order' => $order])->applyProductDiscounts();

		$checkout->calculateOrderTotal($order);

		return redirect()->route('order', ['id' => $order->id])->with('status', 'Your order has been placed.');
	}
}
