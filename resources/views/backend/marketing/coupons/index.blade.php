@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Coupons')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			@can('add_coupons')
                <a href="{{ route('coupon.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Coupon')}}</span>
                </a>
            @endcan
		</div>
	</div>
</div>

<div class="card">
  <div class="card-header">
      <h5 class="mb-0 h6">{{translate('Coupon Information')}}</h5>
  </div>
  <div class="card-body">
      <table class="table aiz-table p-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Code')}}</th>
                    <th  data-breakpoints="lg">{{translate('Type')}}</th>
                    <th data-breakpoints="lg">{{translate('Start Date')}}</th>
                    <th data-breakpoints="lg">{{translate('End Date')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $key => $coupon)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$coupon->code}}</td>
                        <td>@if ($coupon->type == 'cart_base')
                                {{ translate('Cart Base') }}
                            @elseif ($coupon->type == 'product_base')
                                {{ translate('Product Base') }}
                        @endif</td>
                        <td>{{ date('d-m-Y', $coupon->start_date) }}</td>
                        <td>{{ date('d-m-Y', $coupon->end_date) }}</td>
						<td class="text-right">
                            @can('edit_coupons')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('coupon.edit', encrypt($coupon->id) )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_coupons')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coupon.destroy', $coupon->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection
