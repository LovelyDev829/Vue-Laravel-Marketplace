@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <span class="avatar avatar-xxl mb-3">
                        @if ($user->avatar != null)
                            <img src="{{ uploaded_asset($user->avatar) }}">
                        @else
                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}0"
                                onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/avatar-place.png') }}';">
                        @endif
                    </span>
                    <h1 class="h5 mb-1">{{ $user->name }}</h1>
                    <div class="text-left mt-5">
                        <h6 class="separator mb-4 text-left"><span
                                class="bg-white pr-3">{{ translate('Account Information') }}</span></h6>
                        <p class="text-muted">
                            <strong>{{ translate('Full Name') }} :</strong>
                            <span class="ml-2">{{ $user->name }}</span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Email') }} :</strong>
                            <span class="ml-2">
                                {{ $user->email }}
                            </span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Phone') }} :</strong>
                            <span class="ml-2">
                                {{ $user->phone }}
                            </span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Registration Date') }} :</strong>
                            <span class="ml-2">
                                {{ $user->created_at }}
                            </span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Balance') }} :</strong>
                            <span class="ml-2">
                                {{ format_price($user->balance) }}
                            </span>
                        </p>
                    </div>
                    <div class="text-left mt-5">
                        <h6 class="separator mb-4 text-left">
                            <span class="bg-white pr-3">{{ translate('Others Information') }}
                            </span>
                        </h6>
                        <p class="text-muted">
                            <strong>{{ translate('Number of Orders') }} :</strong>
                            <span class="ml-2">{{ $user->orders()->count() }}</span>
                        </p>
                        <p class="text-muted">
                            <strong>{{ translate('Ordered Amount') }} :</strong>
                            <span class="ml-2">{{ format_price($user->orders()->sum('grand_total')) }}</span>
                        </p>
                        <p class="text-muted">
                            <strong>{{ translate('Number of items in cart') }} :</strong>
                            <span class="ml-2">{{ $user->carts()->count() }}</span>
                        </p>
                        <p class="text-muted">
                            <strong>{{ translate('Number of items in wishlist') }} :</strong>
                            <span class="ml-2">{{ $user->wishlists()->count() }}</span>
                        </p>
                        <p class="text-muted">
                            <strong>{{ translate('Total reviewed products') }} :</strong>
                            <span class="ml-2">{{ $user->reviews()->count() }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    {{ translate('Orders of this customer') }}
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Order Code') }}</th>
                                <th>{{ translate('Amount') }}</th>
                                <th data-breakpoints="lg">{{ translate('Delivery Status') }}</th>
                                <th data-breakpoints="lg">{{ translate('Payment Status') }}</th>
                                <th data-breakpoints="lg" class="text-right" width="15%">{{ translate('options') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->orders()->latest()->get()
        as $key => $order)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $order->code }}
                                    </td>
                                    <td>
                                        {{ format_price($order->grand_total) }}
                                    </td>
                                    <td>
                                        <span
                                            class="text-capitalize">{{ translate(str_replace('_', ' ', $order->delivery_status)) }}</span>
                                    </td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                        @else
                                            <span
                                                class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @can('view_orders')
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('orders.show', $order->id) }}"
                                                title="{{ translate('View') }}">
                                                <i class="las la-eye"></i>
                                            </a>
                                        @endcan
                                        @can('invoice_download')
                                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                href="{{ route('orders.invoice.download', $order->id) }}"
                                                title="{{ translate('Download Invoice') }}">
                                                <i class="las la-download"></i>
                                            </a>
                                        @endcan
                                        @can('delete_orders')
                                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="{{ route('orders.destroy', $order->id) }}"
                                                title="{{ translate('Delete') }}">
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
        </div>
    </div>
@endsection
