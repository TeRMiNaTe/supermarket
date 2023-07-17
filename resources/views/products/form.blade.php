<div class="card">
	<div class="card-header text-center font-weight-bold">
		{{ ucfirst($action) }} a Product
	</div>
	<div class="card-body">
		<form method="post" action="{{ $route }}">
		@csrf

		@isset($product)
		<input type="hidden" name="_method" value="put" />
		@endif
		<div class="form-group mb-3">
			<label for="sku">SKU</label>
			<input name="SKU" class="form-control" id="sku" placeholder="ABCD" value="{{ $product?->SKU ?? '' }}">
		</div>
		<div class="form-group mb-3">
			<label for="price">Price</label>
			<input name="price" class="form-control" id="price" placeholder="50" value="{{ $product?->price ?? '' }}">
		</div>
		<div class="d-grid gap-2">
			<button type="submit" class="btn btn-primary">{{ ucfirst($action) }} Product</button>
		</div>
	</form>
</div>
