@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3">{{translate('All Values')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7 col-xl-8">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ $attribute->name.' '.translate('Values')}}</h5>
			</div>
			<div class="card-body">
				<table class="table aiz-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ translate('Attribute Value')}}</th>
							<th>{{ translate('Attribute')}}</th>
							<th class="text-right">{{ translate('Actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($attribute_values as $key => $attribute_value)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$attribute_value->getTranslation('name')}}</td>
								<td>{{$attribute_value->attribute->getTranslation('name')}}</td>
								<td class="text-right">
									<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('attribute_values.edit', ['id'=>$attribute_value->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
										<i class="las la-edit"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="aiz-pagination">
					{{ $attribute_values->appends(request()->input())->links() }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-xl-4">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Add New Values') }}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('attribute_values.store') }}" method="POST">
					@csrf
					<div class="alert alert-info">
						{{ translate('Attribute values are non deletable. You can only add or edit.') }}
					</div>
					<div class="form-group mb-3">
						<label for="name">{{translate('Attribute')}}</label>
				 		<input type="hidden" name="attribute_id" value="{{ $attribute->id }}" class="form-control" >
						<div class="form-control" readonly>{{ $attribute->name }}</div>
					</div>
					<div class="form-group mb-3">
						<label for="name">{{translate('Attribute Value Name')}}</label>
						<input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required>
					</div>
					<div class="form-group mb-3 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Add')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection
