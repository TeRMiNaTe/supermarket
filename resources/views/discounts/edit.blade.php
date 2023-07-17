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

	@include('discounts.form', ['route' => route('discounts.update', ['discount' => $discount->id]), 'discount' => $discount, 'action' => 'update'])
@endsection
