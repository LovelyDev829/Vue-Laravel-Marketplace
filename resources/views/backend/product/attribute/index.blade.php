@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3">{{translate('All Attributes')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7 col-xl-8">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Attributes')}}</h5>
			</div>
			<div class="card-body">
				<table class="table aiz-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ translate('Name')}}</th>
							<th data-breakpoints="lg">{{ translate('Values')}}</th>
							<th class="text-right">{{ translate('Actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($attributes as $key => $attribute)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$attribute->getTranslation('name')}}</td>
								<td>
									@foreach($attribute->attribute_values as $key => $value)
										<span class="badge badge-inline badge-md bg-soft-dark mb-1">{{ $value->getTranslation('name') }}</span>
									@endforeach
								</td>
								<td class="text-right">
									@can('configure_attributes', Model::class)
										<a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('attributes.show', ['attribute'=>$attribute->id] )}}" title="{{ translate('Values') }}">
											<i class="las la-cog"></i>
										</a>
									@endcan
									@can('edit_attributes', Model::class)
										<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('attributes.edit', ['id'=>$attribute->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
											<i class="las la-edit"></i>
										</a>
									@endcan
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="aiz-pagination">
					{{ $attributes->appends(request()->input())->links() }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-xl-4">
		@can('add_attributes')
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0 h6">{{ translate('Add New Attribute') }}</h5>
				</div>
				<div class="card-body">
					<form action="{{ route('attributes.store') }}" method="POST">
						@csrf
						<div class="alert alert-info">
							{{ translate('Attributes are non deletable. You can only add or edit.') }}
						</div>
						<div class="form-group mb-3">
							<label for="name">{{translate('Name')}}</label>
							<input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required>
						</div>
						<div class="form-group mb-3 text-right">
							<button type="submit" class="btn btn-primary">{{translate('Add')}}</button>
						</div>
					</form>
				</div>
			</div>
		@endcan
	</div>
</div>
@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection
