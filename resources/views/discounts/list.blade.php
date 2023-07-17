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
	@elseif(session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif

	<div class="card">
		<div class="card-header text-center font-weight-bold">
			Discounts
		</div>
		<div class="card-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Product</th>
						<th scope="col">Price (Single)</th>
						<th scope="col">Quantity</th>
						<th scope="col">Price</th>
						<th scope="col">Update</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($discounts as $discount)
					<tr class="align-middle">
						<td>{{ $discount->id }}</td>
						<td>{{ $discount->product->SKU }}</td>
						<td>${{ $discount->product->price }}</td>
						<td>{{ $discount->quantity }}</td>
						<td>${{ $discount->price }}</td>
						<td>
							<a class="btn btn-outline-primary" href="{{ route('discounts.edit', ['discount' => $discount->id]) }}" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
								<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
								</svg>
							</a>
						</td>
						<td>
							<form id="discount-select" method="post" action="{{ route('discounts.destroy', ['discount' => $discount->id]) }}">
								@csrf
								<input type="hidden" name="_method" value="delete" />
								<button type="submit" class="btn btn-danger">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
										<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
										<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
									</svg>
								</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<div class="d-grid gap-2 mt-3">
				<a href="{{ route('discounts.create') }}" class="btn btn-outline-primary" role="button">Create a discount</a>
			</div>
		</div>
	</div>

	<div class="d-grid gap-2 mt-4">
		<a href="{{ route('shop') }}" class="btn btn-outline-primary" role="button">Back to shop</a>
	</div>
@endsection
