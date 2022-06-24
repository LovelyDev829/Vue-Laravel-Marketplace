@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Cash Payment Activation') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-from-label">{{ translate('Activation') }}</label>
                        </div>
                        <div class="col-md-4">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'cash_payment')"
                                    @if (get_setting('cash_payment') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Paypal --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Paypal Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'paypal_payment')"
                                        @if (get_setting('paypal_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Client Id') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYPAL_CLIENT_ID"
                                    value="{{ env('PAYPAL_CLIENT_ID') }}"
                                    placeholder="{{ translate('Paypal Client ID') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Client Secret') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET"
                                    value="{{ env('PAYPAL_CLIENT_SECRET') }}"
                                    placeholder="{{ translate('Paypal Client Secret') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Paypal Sandbox Mode') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="paypal_sandbox" type="checkbox"
                                        onchange="updateSettings(this, 'paypal_sandbox')" @if (get_setting('paypal_sandbox') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sslcommerz --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header ">
                    <h5 class="mb-0 h6">{{ translate('Sslcommerz Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'sslcommerz_payment')"
                                        @if (get_setting('sslcommerz_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SSLCZ_STORE_ID">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Sslcz Store Id') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="SSLCZ_STORE_ID"
                                    value="{{ env('SSLCZ_STORE_ID') }}"
                                    placeholder="{{ translate('Sslcz Store Id') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="SSLCZ_STORE_PASSWD">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Sslcz store password') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="SSLCZ_STORE_PASSWD"
                                    value="{{ env('SSLCZ_STORE_PASSWD') }}"
                                    placeholder="{{ translate('Sslcz store password') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Sslcommerz Sandbox Mode') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="sslcommerz_sandbox" type="checkbox"
                                        onchange="updateSettings(this, 'sslcommerz_sandbox')" @if (get_setting('sslcommerz_sandbox') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Stripe --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Stripe Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'stripe_payment')"
                                        @if (get_setting('stripe_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="STRIPE_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Stripe Key') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="STRIPE_KEY"
                                    value="{{ env('STRIPE_KEY') }}" placeholder="{{ translate('STRIPE KEY') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="STRIPE_SECRET">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Stripe Secret') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="STRIPE_SECRET"
                                    value="{{ env('STRIPE_SECRET') }}" placeholder="{{ translate('STRIPE SECRET') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PayStack --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('PayStack Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'paystack_payment')"
                                        @if (get_setting('paystack_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYSTACK_PUBLIC_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('PUBLIC KEY') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYSTACK_PUBLIC_KEY"
                                    value="{{ env('PAYSTACK_PUBLIC_KEY') }}"
                                    placeholder="{{ translate('PUBLIC KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYSTACK_SECRET_KEY">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('SECRET KEY') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="PAYSTACK_SECRET_KEY"
                                    value="{{ env('PAYSTACK_SECRET_KEY') }}"
                                    placeholder="{{ translate('SECRET KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="MERCHANT_EMAIL">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('MERCHANT EMAIL') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="MERCHANT_EMAIL"
                                    value="{{ env('MERCHANT_EMAIL') }}"
                                    placeholder="{{ translate('MERCHANT EMAIL') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Flutterwave Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'flutterwave_payment')"
                                        @if (get_setting('flutterwave_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="FLW_PUBLIC_KEY">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('FLW_PUBLIC_KEY') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="FLW_PUBLIC_KEY"
                                    value="{{ env('FLW_PUBLIC_KEY') }}"
                                    placeholder="{{ translate('FLW_PUBLIC_KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="FLW_SECRET_KEY">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('FLW_SECRET_KEY') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="FLW_SECRET_KEY"
                                    value="{{ env('FLW_SECRET_KEY') }}"
                                    placeholder="{{ translate('FLW_SECRET_KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="FLW_SECRET_HASH">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('FLW_ENCRYPTION_KEY') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="FLW_SECRET_HASH"
                                    value="{{ env('FLW_SECRET_HASH') }}"
                                    placeholder="{{ translate('FLW_ENCRYPTION_KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="FLW_PAYMENT_CURRENCY_CODE">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('FLW_PAYMENT_CURRENCY_CODE') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="FLW_PAYMENT_CURRENCY_CODE"
                                    value="{{ env('FLW_PAYMENT_CURRENCY_CODE') }}"
                                    placeholder="{{ translate('FLW_PAYMENT_CURRENCY_CODE') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Paytm Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'paytm_payment')"
                                        @if (get_setting('paytm_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_ENVIRONMENT">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM ENVIRONMENT') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_ENVIRONMENT"
                                    value="{{ env('PAYTM_ENVIRONMENT') }}" placeholder="local or production" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_ID">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM MERCHANT ID') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_MERCHANT_ID"
                                    value="{{ env('PAYTM_MERCHANT_ID') }}" placeholder="PAYTM MERCHANT ID" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_KEY">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM MERCHANT KEY') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_MERCHANT_KEY"
                                    value="{{ env('PAYTM_MERCHANT_KEY') }}" placeholder="PAYTM MERCHANT KEY">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_WEBSITE">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM MERCHANT WEBSITE') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_MERCHANT_WEBSITE"
                                    value="{{ env('PAYTM_MERCHANT_WEBSITE') }}" placeholder="PAYTM MERCHANT WEBSITE">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_CHANNEL">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM CHANNEL') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_CHANNEL"
                                    value="{{ env('PAYTM_CHANNEL') }}" placeholder="PAYTM CHANNEL">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="PAYTM_INDUSTRY_TYPE">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('PAYTM INDUSTRY TYPE') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="PAYTM_INDUSTRY_TYPE"
                                    value="{{ env('PAYTM_INDUSTRY_TYPE') }}" placeholder="PAYTM INDUSTRY TYPE">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Razorpay Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-from-label">{{ translate('Activation') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'razorpay_payment')" @if (get_setting('razorpay_payment') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="RAZOR_KEY">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('Razorpay Key') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="RAZOR_KEY" value="{{ env('RAZOR_KEY') }}" placeholder="Key">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="RAZOR_SECRET">
                            <div class="col-lg-4">
                                <label class="col-from-label">{{ translate('Razorpay Secret') }}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="RAZOR_SECRET" value="{{ env('RAZOR_SECRET') }}" placeholder="secret">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
