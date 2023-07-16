@extends('layouts.main')

@section('content')
	@if(session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<div class="card">
		<div class="card-header text-center font-weight-bold">
			Order #{{ $order->id }}
		</div>
		<div class="card-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">SKU</th>
						<th scope="col">Original Price</th>
						<th scope="col">Price</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($order->products as $product)
					<tr>
						<th scope="row">{{ $loop->iteration }}</th>
						<td>{{ $product->product->SKU }}</td>
						<td>${{ $product->original_price }}</td>
						<td>${{ $product->price }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th scope="row">Total</th>
						<td scope="col"></td>
						<td scope="col"></td>
						<th scope="row">{{ $order->total }}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

	<div class="d-grid gap-2 mt-3">
		<a href="{{ route('shop') }}" class="btn btn-outline-primary" role="button">Create another order</a>
	</div>
@endsection
