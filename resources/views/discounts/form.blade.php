<div class="card">
	<div class="card-header text-center font-weight-bold">
		{{ ucfirst($action) }} a Product Discount
	</div>
	<div class="card-body">
		<form method="post" action="{{ $route }}">
		@csrf

		@isset($discount)
		<input type="hidden" name="_method" value="put" />
		@endif

		<label class="form-label mb-3">Product</label>
		<select name="product_id" class="form-select mb-3">
			@foreach ($products as $product)
			<option value="{{ $product->id }}" {{ isset($discount) && $product->id == $discount->product_id ? 'selected' : '' }}>{{ $product->SKU }} (${{ $product->price }})</option>
			@endforeach
		</select>

		<div class="form-group mb-3">
			<label for="quantity">Quantity</label>
			<input name="quantity" class="form-control" id="quantity" placeholder="5" value="{{ $discount?->quantity ?? '' }}">
		</div>
		<div class="form-group mb-3">
			<label for="price">Total Price</label>
			<input name="price" class="form-control" id="price" placeholder="150" value="{{ $discount?->price ?? '' }}">
		</div>
		<div class="d-grid gap-2">
			<button type="submit" class="btn btn-primary">{{ ucfirst($action) }} Product Discount</button>
		</div>
	</form>
</div>
