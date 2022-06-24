@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-4">
			<h1 class="h3">{{translate('All Zones')}}</h1>
		</div>
		<div class="col-md-8 text-md-right">
			<a href="{{ route('zones.create') }}" class="btn btn-primary">
				<span>{{translate('Add New Zone')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Cities')}}</th>
                    <th>{{translate('Standard Delivery Cost')}}</th>
                    <th>{{translate('Express Delivery Cost')}}</th>
                    <th data-breakpoints="md" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zones as $key => $zone)
                    <tr>
                        <td>{{ ($key+1) + ($zones->currentPage() - 1)*$zones->perPage() }}</td>
                        <td>
                            {{ $zone->name }}
                        </td>
                        <td>
                            @foreach (json_decode($zone->cities ?? '[]') as $city_id)
                                @php $city = App\Models\City::find($city_id); @endphp
                                @if($city)
                                    <span class="badge badge-inline badge-md bg-soft-dark mb-1">{{ $city->name }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            {{ format_price($zone->standard_delivery_cost) }}
						</td>
                        <td>
                            {{ format_price($zone->express_delivery_cost) }}
						</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('zones.edit', $zone->id)}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('zones.destroy', $zone->id) }}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
				        </td>
	          		</tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $zones->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection
