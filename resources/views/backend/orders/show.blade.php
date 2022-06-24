@extends('backend.layouts.app')

@section('content')
    <h1 class="h4 fw-700 mb-3">{{ translate('Order code') }}: {{ $order->combined_order->code }}</h1>
    <div class="row gutters-5">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h2 class="h2 fs-16 fw-600 mb-0">{{ translate('Order Details') }}</h2>
                </div>
                <div class="card-header">
                    <div class="flex-grow-1 row">
                        <div class="col-md mb-3">
                            <div>
                                <div class="fs-15 fw-600 mb-2">{{ translate('Customer info') }}</div>
                                <div><span class="opacity-80 mr-2 ml-0">{{ translate('Name') }}:</span>
                                    {{ $order->user->name ?? '' }}</div>
                                <div><span class="opacity-80 mr-2 ml-0">{{ translate('Email') }}:</span>
                                    {{ $order->user->email ?? '' }}</div>
                                <div><span class="opacity-80 mr-2 ml-0">{{ translate('Phone') }}:</span>
                                    {{ $order->user->phone ?? '' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td class="">{{ translate('Order code') }}:</td>
                                        <td class="text-right text-info fw-700">{{ $order->combined_order->code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ translate('Order Date') }}:</td>
                                        <td class="text-right fw-700">{{ $order->created_at->format('d.m.Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ translate('Delivery type') }}:</td>
                                        <td class="text-right fw-700">
                                            {{ ucfirst(str_replace('_', ' ', $order->delivery_type)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ translate('Payment method') }}:</td>
                                        <td class="text-right fw-700">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="flex-grow-1 row align-items-start">

                        <div class="col-md-3 mr-auto ml-0">
                            <div class="mb-3">
                                <label class="mb-0">{{ translate('Payment Status') }}</label>
                                <select
                                    class="form-control aiz-selectpicker"
                                    id="update_payment_status"
                                    data-minimum-results-for-search="Infinity"
                                    data-selected="{{ $order->payment_status }}"
                                    @if($order->payment_status == 'paid' || $order->delivery_status == 'delivered' || $order->delivery_status == 'cancelled') disabled @endif
                                >
                                    <option value="paid">{{ translate('Paid') }}</option>
                                    <option value="unpaid">{{ translate('Unpaid') }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">{{ translate('Delivery Status') }}</label>
                                <select
                                    class="form-control aiz-selectpicker"
                                    id="update_delivery_status"
                                    data-minimum-results-for-search="Infinity"
                                    data-selected="{{ $order->delivery_status }}"
                                    @if($order->delivery_status == 'delivered' || $order->delivery_status == 'cancelled') disabled @endif
                                >
                                    <option value="confirmed">{{ translate('Confirmed') }}</option>
                                    <option value="processed">{{ translate('Processed') }}</option>
                                    <option value="shipped">{{ translate('Shipped') }}</option>
                                    <option value="delivered">{{ translate('Delivered') }}</option>
                                    <option value="cancelled">{{ translate('Cancel') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-auto w-md-250px">
                            @php
                                $shipping_address = json_decode($order->shipping_address);
                            @endphp
                            <h5 class="fs-14 mb-3">{{ translate('Shipping address') }}</h5>
                            <address class="">
                                {{ $shipping_address->phone }}<br>
                                {{ $shipping_address->address }}<br>
                                {{ $shipping_address->city }}, {{ $shipping_address->postal_code }}<br>
                                {{ $shipping_address->state }}, {{ $shipping_address->country }}
                            </address>
                        </div>
                        <div class="col-md-auto w-md-250px">
                            @php
                                $billing_address = json_decode($order->billing_address);
                            @endphp
                            <h5 class="fs-14 mb-3">{{ translate('Billing address') }}</h5>
                            <address class="">
                                {{ $billing_address->phone }}<br>
                                {{ $billing_address->address }}<br>
                                {{ $billing_address->city }}, {{ $billing_address->postal_code }}<br>
                                {{ $billing_address->state }}, {{ $billing_address->country }}
                            </address>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="aiz-table table-bordered">
                        <thead>
                            <tr class="">
                                <th class="text-center" width="5%" data-breakpoints="lg">#</th>
                                <th width="40%">{{ translate('Product') }}</th>
                                <th class="text-center" data-breakpoints="lg">{{ translate('Qty') }}</th>
                                <th class="text-center" data-breakpoints="lg">{{ translate('Unit Price') }}</th>
                                <th class="text-center" data-breakpoints="lg">{{ translate('Unit Tax') }}</th>
                                <th class="text-center" data-breakpoints="lg">{{ translate('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($orderDetail->product != null)
                                            <div class="media">
                                                <img src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"
                                                    class="size-60px mr-3">
                                                <div class="media-body">
                                                    <h4 class="fs-14 fw-400">{{ $orderDetail->product->name }}</h4>
                                                    @if ($orderDetail->variation)
                                                        <div>
                                                            @foreach ($orderDetail->variation->combinations as $combination)
                                                                <span class="mr-2">
                                                                    <span
                                                                        class="opacity-50">{{ $combination->attribute->name }}</span>:
                                                                    {{ $combination->attribute_value->name }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                                    <td class="text-center">{{ format_price($orderDetail->price) }}</td>
                                    <td class="text-center">{{ format_price($orderDetail->tax) }}</td>
                                    <td class="text-center">{{ format_price($orderDetail->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xl-4 col-md-6 ml-auto mr-0">
                            <table class="table">
                                <tbody>
                                    @php
                                        $totalTax = 0;
                                        foreach ($order->orderDetails as $item) {
                                            $totalTax += $item->tax * $item->quantity;
                                        }
                                    @endphp
                                    <tr>
                                        <td><strong class="">{{ translate('Sub Total') }} :</strong></td>
                                        <td>
                                            {{ format_price($order->orderDetails->sum('total') - $totalTax) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class="">{{ translate('Tax') }} :</strong></td>
                                        <td>{{ format_price($totalTax) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong class=""> {{ translate('Shipping') }} :</strong></td>
                                        <td>{{ format_price($order->shipping_cost) }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class=""> {{ translate('Coupon discount') }} :</strong>
                                            @if ($order->coupon_code)
                                                <div>({{ $order->coupon_code }})</div>
                                            @endif
                                        </td>
                                        <td>{{ format_price($order->coupon_discount) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong class="">{{ translate('TOTAL') }} :</strong></td>
                                        <td class=" h4">
                                            {{ format_price($order->grand_total) }}
                                        </td>
                                    </tr>
                                    @if (addon_is_activated('refund') && $order->refund_amount > 0)
                                        <tr>
                                            <td>
                                                <strong class="text-danger"> {{ translate('Refunded') }} :</strong>
                                            </td>
                                            <td><span class="text-danger">- {{ format_price($order->refund_amount) }}</span></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if (addon_is_activated('refund'))
                @can('show_refund_requests')
                    @php $refund_request = \App\Models\RefundRequest::where('order_id',$order->id)->first(); @endphp
                    <div class="card">
                        <div class="card-header">
                            <h3 class="fs-16 mb-0">{{ translate('Refund requests') }}</h3>
                            @php
                                $refund_request_time_period = get_setting('refund_request_time_period');
                                $last_refund_date = $orderDetail->created_at->addDays($refund_request_time_period);
                                $today_date = Carbon\Carbon::now();
                                $refund_request_order_status = get_setting('refund_request_order_status') != null ? json_decode(get_setting('refund_request_order_status')) : [];
                                
                            @endphp
                            @if ($order->payment_status == 'paid' && in_array($order->delivery_status, $refund_request_order_status) && $refund_request == null && $today_date <= $last_refund_date)
                                <a href="{{ route('admin.refund_request.create', $order->id) }}"
                                    class="btn btn-sm btn-primary">{{ translate('Create Refund') }}</a>
                            @endif
                        </div>
                        <div class="card-body">

                            @if ($refund_request != null)
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="10%">#</th>
                                            <th>{{ translate('Name') }}</th>
                                            <th class="text-center" data-breakpoints="lg">{{ translate('Qty') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($refund_request->refundRequestItems as $key => $refundRequestItem)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="media">
                                                        <img src="{{ uploaded_asset($refundRequestItem->orderDetail->product->thumbnail_img) }}"
                                                            class="size-60px mr-3">
                                                        <div class="media-body">
                                                            <h4 class="fs-14 fw-400">
                                                                {{ $refundRequestItem->orderDetail->product->name }}
                                                            </h4>
                                                            @if ($refundRequestItem->orderDetail->variation)
                                                                <div>
                                                                    @foreach ($refundRequestItem->orderDetail->variation->combinations as $combination)
                                                                        <span class="mr-2">
                                                                            <span
                                                                                class="opacity-50">{{ $combination->attribute->name }}</span>:
                                                                            {{ $combination->attribute_value->name }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $refundRequestItem->quantity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 ml-auto mr-0">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><strong
                                                            class="">{{ translate('Refund Amount') }}:</strong>
                                                    </td>
                                                    <td>
                                                        {{ format_price($refund_request->amount) }}
                                                    </td>
                                                </tr>
                                                @if ($order->refund_status != null)
                                                    <tr>
                                                        <td><strong class="">{{ translate('Refund Type') }}
                                                                :</strong></td>
                                                        <td>{{ $order->refund_status == 'partially_refunded' ? translate('Partial') : translate('Full') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($refund_request->shop->user->user_type == 'seller')
                                                    <tr>
                                                        <td>
                                                            <strong
                                                                class="">{{ translate('Seller Approval') }}:</strong>
                                                        </td>
                                                        <td>
                                                            @if ($refund_request->seller_approval == 0)
                                                                <span
                                                                    class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                                            @elseif($refund_request->seller_approval == 1)
                                                                <span
                                                                    class="badge badge-inline badge-success">{{ translate('Accepted') }}</span>
                                                            @elseif($refund_request->seller_approval == 2)
                                                                <span
                                                                    class="badge badge-inline badge-danger">{{ translate('Rejected') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><strong class="">{{ translate('Status') }}
                                                            :</strong></td>
                                                    <td>
                                                        @if ($refund_request->admin_approval == 0)
                                                            <span
                                                                class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                                        @elseif($refund_request->admin_approval == 1)
                                                            <span
                                                                class="badge badge-inline badge-success">{{ translate('Accepted') }}</span>
                                                        @elseif($refund_request->admin_approval == 2)
                                                            <span
                                                                class="badge badge-inline badge-danger">{{ translate('Rejected') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="">{{ translate('Options') }}:</strong>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                            onclick="show_refund_request_info('{{ $refund_request->id }}');"
                                                            title="{{ translate('Refund Request Info') }}"
                                                            href="javascript:void(0)">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                        @if ($refund_request->admin_approval == 0)
                                                            <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                                                onclick="accept_refund_request({{ $refund_request->id }},{{ $refund_request->amount }})"
                                                                title="{{ translate('Accept Refund Request') }}"
                                                                href="javascript:void(0)">
                                                                <i class="las la-check"></i>
                                                            </a>
                                                            <a class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                                                onclick="reject_refund_request('{{ route('admin.refund_request.reject', $refund_request->id) }}')"
                                                                title="{{ translate('Reject Refund Request') }}"
                                                                href="javascript:void(0)">
                                                                <i class="las la-times"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endcan
            @endif
            @if (addon_is_activated('multi_vendor') && optional(optional($order->shop)->user)->user_type != 'admin')
                <div class="card">
                    <div class="card-header">
                        <h3 class="fs-16 mb-0">{{ translate('Earning History') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Admin Commission') }}</th>
                                    <th>{{ translate('Seller Earning') }}</th>
                                    <th data-breakpoints="lg">{{ translate('Details') }}</th>
                                    <th class="text-center">{{ translate('Type') }}</th>
                                    <th data-breakpoints="lg" class="text-right">{{ translate('Calculated At') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->commission_histories()->latest()->get() as $history)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ format_price($history->admin_commission) }}</td>
                                    <td>{{ format_price($history->seller_earning) }}</td>
                                    <td>{{ $history->details }}</td>
                                    <td class="text-center">
                                        @if ($history->type == 'Added')
                                            <span class="badge badge-inline badge-success">{{ translate($history->type) }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate($history->type) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $history->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="col col-lg-auto w-lg-300px">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-16 mb-0">{{ translate('Tracking information') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.add_tracking_information') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="form-group mb-1">
                            <label class="mb-0">{{ translate('Courier name') }}:</label>
                            <input type="text" class="form-control form-control-sm" name="courier_name" value="{{ $order->courier_name }}" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="mb-0">{{ translate('Tracking number') }}:</label>
                            <input type="text" class="form-control form-control-sm" name="tracking_number" value="{{ $order->tracking_number }}" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="mb-0">{{ translate('Tracking url') }}:</label>
                            <input type="text" class="form-control form-control-sm" name="tracking_url" value="{{ $order->tracking_url }}" required>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-sm btn-primary" type="submit">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-16 mb-0">{{ translate('Order updates') }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($order->order_udpates as $order_udpate)
                        <div class="mb-3">
                            <div class="p-2 bg-soft-secondary rounded">
                                {{ $order_udpate->translatable_note ? translate($order_udpate->note) : $order_udpate->note }}
                            </div>
                            <span
                                class="fs-12 opacity-60">{{ translate('by') .' ' .($order_udpate->user->name ?? translate('Deleted user')) .' at ' .$order_udpate->created_at->format('h:ia, d-m-Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Refund Information Modal -->
    <div class="modal fade" id="refund_request_info_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="refund-request-info-modal-content">

            </div>
        </div>
    </div>

    {{-- Accept refund request Modal --}}
    <div id="accept_refund_request_modal" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Accept Refund Request.') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form class="form-horizontal member-block" action="{{ route('admin.refund_request.accept') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="refund_request_id" id="refund_request_id" value="">

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label" for="amount">{{ translate('Amount') }}</label>
                            <div class="col-md-9">
                                <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value=""
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            {{ translate('Select Pay in Wallet to refund in the customer wallet. And select Pay Manually to refund customer manually.') }}
                        </div>
                        <div class="alert alert-info">
                            {{ translate('This amount is without shipping cost. If you want to add shipping cost you can change this amount.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mt-2"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" name="button" value="manual"
                            class="btn btn-success">{{ translate('Pay Manually') }}</button>
                        <button type="submit" name="button" value="wallet"
                            class="btn btn-primary">{{ translate('Pay in Wallet') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Refund request Modal --}}
    <div id="reject_refund_request_modal" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Reject Refund Request.') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class='fs-14'>{{ translate('Do you really want to reject this refund Request?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mt-2"
                        data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a href="" id="reject_refund_request_link" class="btn btn-primary">{{ translate('Reject') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                window.location.reload();
            });
        });
        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                window.location.reload();
            });
        });
        // Refund Request
        function show_refund_request_info(id) {
            $.post('{{ route('admin.refund_request.view_details') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#refund-request-info-modal-content').html(data);
                $('#refund_request_info_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }
        function accept_refund_request(id, amount) {
            $('#accept_refund_request_modal').modal('show');
            $('#refund_request_id').val(id);
            $('#amount').val(amount);
        }
        function reject_refund_request(url) {
            $('#reject_refund_request_modal').modal('show');
            document.getElementById('reject_refund_request_link').setAttribute('href', url);
        }
    </script>
@endsection