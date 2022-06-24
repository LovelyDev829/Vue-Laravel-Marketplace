<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style media="all">
        @page {
            padding: 0;
            margin: 20px;
        }

        body {
            font-size: 0.75rem;
            font-family: '<?php echo $font_family; ?>';
            font-weight: normal;
            direction: <?php echo $direction; ?>;
            text-align: <?php echo $default_text_align; ?>;
            padding: 0;
            margin: 0;
            color: #232323;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: 0 .8rem;
        }

        table.padding td {
            padding: .8rem;
        }

        table.sm-padding td {
            padding: .5rem .7rem;
        }

        table.lg-padding td {
            padding: 1rem 1.2rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: <?php echo $default_text_align; ?>;
        }

        .text-right {
            text-align: <?php echo $reverse_text_align; ?>;
        }

        .bold {
            font-weight: bold
        }

    </style>
</head>

<body>
    <div>
        <div style="padding:0px 19px;">
            <table>
                <thead>
                    <tr>
                        <th width="50%"></th>
                        <th width="50%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            @if (get_setting('invoice_logo') != null)
                                                <img src="{{ uploaded_asset(get_setting('invoice_logo')) }}"
                                                    height="30" style="display:inline-block;margin-bottom:10px">
                                            @else
                                                <img src="{{ static_asset('assets/img/logo.png') }}" height="30"
                                                    style="display:inline-block;margin-bottom:10px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" class="bold">{{ get_setting('site_name') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ get_setting('invoice_address') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ translate('Email') }}:
                                            {{ get_setting('invoice_email') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">{{ translate('Phone') }}:
                                            {{ get_setting('invoice_phone') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="text-right">
                                <tbody>
                                    <tr>
                                        <td style="font-size: 2rem;" class="bold">{{ translate('INVOICE') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            <span class=" ">{{ translate('Order Code') }}:</span>
                                            <span class="bold"
                                                style="color: #ED2939">{{ $order->combined_order->code }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            <span class=" ">{{ translate('Order Date') }}:</span>
                                            <span
                                                class="bold">{{ $order->created_at->format('d.m.Y') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class=" ">{{ translate('Delivery type') }}:</span>
                                            <span class="bold"
                                                style="text-transform: capitalize">{{ translate($order->delivery_type) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin:8px 8px 15px 8px; clear:both">
            <div style="padding:10px 14px; border:1px solid #DEDEDE;border-radius:3px;width:45%;float:left;">
                <table class="">
                    <tbody>
                        @php
                            $billing_address = json_decode($order->billing_address);
                        @endphp
                        <tr>
                            <td class="bold">{{ translate('Billing address') }}:</td>
                        </tr>
                        <tr>
                            <td class="">{{ $billing_address->address }},
                                {{ $billing_address->postal_code }}</td>
                        </tr>
                        <tr>
                            <td class="">{{ $billing_address->city }},
                                {{ $billing_address->state }}, {{ $billing_address->country }}</td>
                        </tr>
                        <tr>
                            <td class="">{{ translate('Phone') }}: {{ $billing_address->phone }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="padding:10px 14px; border:1px solid #DEDEDE;border-radius:3px;width:45%;float:right">
                <table class="text-right">
                    <tbody>
                        @php
                            $shipping_address = json_decode($order->shipping_address);
                        @endphp
                        <tr>
                            <td class="bold">{{ translate('Shipping address') }}:</td>
                        </tr>
                        <tr>
                            <td class="">{{ $shipping_address->address }},
                                {{ $shipping_address->postal_code }}</td>
                        </tr>
                        <tr>
                            <td class="">{{ $shipping_address->city }},
                                {{ $shipping_address->state }}, {{ $shipping_address->country }}</td>
                        </tr>
                        <tr>
                            <td class="">{{ translate('Phone') }}: {{ $shipping_address->phone }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin:0 8px;border:1px solid #DEDEDE;border-radius:3px;padding:0 7px">
            <table class="padding">
                <thead>
                    <tr>
                        <td width="5%" class="text-left bold">{{ translate('S/L') }}</td>
                        <td width="45%" class="text-left bold">{{ translate('Product Name') }}</td>
                        <td width="13%" class="text-left bold">{{ translate('Qty') }}</td>
                        <td width="15%" class="text-left bold">{{ translate('Unit Price') }}</td>
                        <td width="10%" class="text-left bold">{{ translate('Unit Tax') }}</td>
                        <td width="12%" class="text-right bold">{{ translate('Total') }}</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="margin:8px;">
            <table class="lg-padding" style="border-collapse: collapse">
                <tr>
                    <th width="6%" class="text-left"></th>
                    <th width="44%" class="text-left"></th>
                    <th width="13%" class="text-left"></th>
                    <th width="15%" class="text-left"></th>
                    <th width="9%" class="text-left"></th>
                    <th width="14%" class="text-right"></th>
                </tr>
                <tbody class="strong">
                    @foreach ($order->orderDetails as $key => $orderDetail)
                        @if ($orderDetail->product != null)
                            <tr>
                                <td style="border-bottom:1px solid #DEDEDE;padding-left:20px">{{ $key + 1 }}</td>
                                <td style="border-bottom:1px solid #DEDEDE;">
                                    <span style="display: block">{{ $orderDetail->product->name }}</span>
                                    @if ($orderDetail->variation && $orderDetail->variation->combinations->count() > 0)
                                        @foreach ($orderDetail->variation->combinations as $combination)
                                            <span style="margin-right:10px">
                                                <span
                                                    class="">{{ $combination->attribute->getTranslation('name') }}</span>:
                                                <span>{{ $combination->attribute_value->getTranslation('name') }}</span>
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="" style="border-bottom:1px solid #DEDEDE;">
                                    {{ $orderDetail->quantity }}</td>
                                <td class="" style="border-bottom:1px solid #DEDEDE;">
                                    {{ format_price($orderDetail->price) }}</td>
                                <td class="" style="border-bottom:1px solid #DEDEDE;">
                                    {{ format_price($orderDetail->tax) }}</td>
                                <td class="text-right bold" style="border-bottom:1px solid #DEDEDE;padding-right:20px;">
                                    {{ format_price($orderDetail->total) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin:15px 8px;clear:both">
            <div style="float: left; width:43%;padding:14px 20px;">
                @if ($order->payment_status == 'paid')
                    <div class="mt-5">
                        <img src="{{ static_asset('assets/img/paid_sticker.svg') }}">
                    </div>
                @elseif($order->payment_type == 'cash_on_delivery')
                    <div class="mt-5">
                        <img src="{{ static_asset('assets/img/cod_sticker.svg') }}">
                    </div>
                @endif
            </div>
            <div style="float: right; width:43%;padding:14px 20px; border:1px solid #DEDEDE;border-radius:3px;">
                <table class="text-right sm-padding" style="border-collapse:collapse">
                    <tbody>
                        @php
                            $totalTax = 0;
                            foreach ($order->orderDetails as $item) {
                                $totalTax += $item->tax * $item->quantity;
                            }
                        @endphp
                        <tr>
                            <td class="text-left" style="border-bottom:1px dotted #B8B8B8">
                                {{ translate('Sub Total') }}</td>
                            <td class="bold" style="border-bottom:1px dotted #B8B8B8">
                                {{ format_price($order->orderDetails->sum('total') - $totalTax) }}</td>
                        </tr>
                        <tr class="">
                            <td class="text-left" style="border-bottom:1px dotted #B8B8B8">
                                {{ translate('Total Tax') }}</td>
                            <td class="bold" style="border-bottom:1px dotted #B8B8B8">
                                {{ format_price($totalTax) }}</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="border-bottom:1px dotted #B8B8B8">
                                {{ translate('Shipping Cost') }}</td>
                            <td class="bold" style="border-bottom:1px dotted #B8B8B8">
                                {{ format_price($order->shipping_cost) }}</td>
                        </tr>
                        <tr class="">
                            <td class="text-left" style="border-bottom:1px solid #DEDEDE">
                                {{ translate('Coupon Discount') }}</td>
                            <td class="bold" style="border-bottom:1px solid #DEDEDE">
                                {{ format_price($order->coupon_discount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-left bold">{{ translate('Grand Total') }}</td>
                            <td class="bold">{{ format_price($order->grand_total) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>
