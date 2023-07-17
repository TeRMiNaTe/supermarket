@extends('layouts.main')

@section('scripts')
	<script src="{{ asset('assets/js/checkout.js') }}"></script>
@endsection

@section('content')
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul class="mb-0">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="card">
		<div class="card-header text-center font-weight-bold">
			Checkout
		</div>
		<div class="card-body">
			<form id="product-select" method="post" action="{{ route('checkout') }}">
			 @csrf
				<label class="form-label mb-3">Products</label>
				<select name="products[]" class="form-select mb-3">
					<option selected disabled>Add product</option>
					@foreach ($products as $product)
					<option value="{{ $product->id }}">{{ $product->SKU }} (${{ $product->price }})</option>
					@endforeach
				</select>
				<div class="d-grid gap-2">
					<button type="submit" class="btn btn-primary">Place Order</button>
				</div>
			</form>
		</div>
	</div>

	<div class="row my-3 mx-2">
		<div class="col-md-6">
			<div class="d-grid gap-2">
				<a href="{{ route('products.index') }}" class="btn btn-outline-primary" role="button">Product List</a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="d-grid gap-2">
				<a href="{{ route('discounts.index') }}" class="btn btn-outline-primary" role="button">Discount List</a>
			</div>
		</div>
	</div>
@endsection
