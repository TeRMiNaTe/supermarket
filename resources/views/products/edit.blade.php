@extends('layouts.main')

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

	@include('products.form', ['route' => route('products.update', ['product' => $product->id]), 'product' => $product, 'action' => 'update'])
@endsection
