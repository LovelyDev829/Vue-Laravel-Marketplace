@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('General Settings') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Name') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="site_name">
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ get_setting('site_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Logo - White') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="system_logo_white">
                                    <input type="hidden" name="system_logo_white"
                                        value="{{ get_setting('system_logo_white') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                <small>{{ translate('Will be used in admin panel side menu') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Logo - Black') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="system_logo_black">
                                    <input type="hidden" name="system_logo_black"
                                        value="{{ get_setting('system_logo_black') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                <small>{{ translate('Will be used in admin panel topbar in mobile + Admin login page') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Timezone') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="timezone">
                                <select name="timezone" class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected="{{ config('app.timezone') }}">
                                    @foreach (timezones() as $key => $value)
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Admin login page background') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="admin_login_background">
                                    <input type="hidden" name="admin_login_background"
                                        value="{{ get_setting('admin_login_background') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Default weight unit') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="weight_unit">
                                <select name="weight_unit" class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected="{{ get_setting('weight_unit') }}">
                                    <option value="kg">kg</option>
                                    <option value="gm">gm</option>
                                    <option value="lbs">lbs</option>
                                    <option value="og">og</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Default dimensions unit') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="dimension_unit">
                                <select name="dimension_unit" class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected="{{ get_setting('dimension_unit') }}">
                                    <option value="m">m</option>
                                    <option value="cm">cm</option>
                                    <option value="mm">mm</option>
                                    <option value="in">in</option>
                                    <option value="yd">yd</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Shop Settings') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('shop_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Minimum order amount') }}</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="min_order" min="0" step="0.01"
                                    value="{{ auth()->user()->shop->min_order }}" required>
                                <small
                                    class="text-muted">{{ translate('Customer need to purchase minimum this amount of admin shop products to place an order.') }}</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Cache Settings') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Current cache version') }}</label>
                            <div class="col-sm-9">
                                <div class="form-control bg-soft-secondary">
                                    {{ get_setting('force_cache_clear_version') }}</div>
                                <input type="hidden" name="types[]" value="force_cache_clear_version">
                                <input type="hidden" name="force_cache_clear_version" class="form-control"
                                    value="{{ strtolower(Str::random(30)) }}">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Force Clear Cache') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Features Activation') }}</h1>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-6 col-from-label">{{ translate('Forcefully HTTPS redirection') }}</label>
                        <div class="col-sm-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'FORCE_HTTPS')"
                                    @if (env('FORCE_HTTPS') == 'On') checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="col-from-label">{{translate('Email Verification')}}</label>
                            <i>
                                <code>({{ translate('You need to configure SMTP correctly to enable this feature.') }}</code> <a href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>)
                            </i>
                        </div>
                        <div class="col-sm-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'email_verification')" @if (get_setting('email_verification') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-sm-6 col-from-label">{{ translate('Wallet System Activation') }}</label>
                        <div class="col-sm-6">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'wallet_system')"
                                    @if (get_setting('wallet_system') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    @if ((float) get_setting('current_version') > 1.3 && addon_is_activated('multi_vendor'))
                        <div class="form-group row">
                            <label
                                class="col-sm-6 col-from-label">{{ translate('Conversation System Activation') }}</label>
                            <div class="col-sm-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="updateSettings(this, 'conversation_system')"
                                        @if (get_setting('conversation_system') == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Chat setting') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Chat logo') }}</label>
                            <div class="col-md-8">
                                <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="types[]" value="customer_chat_logo">
                                    <input type="hidden" name="customer_chat_logo" class="selected-files"
                                        value="{{ get_setting('customer_chat_logo') }}">
                                </div>
                                <div class="file-preview"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Chat name') }}</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="hidden" name="types[]" value="customer_chat_name">
                                    <input type="text" class="form-control" placeholder="" name="customer_chat_name"
                                        value="{{ get_setting('customer_chat_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Invoice setting') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Invoice logo') }}</label>
                            <div class="col-md-8">
                                <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="types[]" value="invoice_logo">
                                    <input type="hidden" name="invoice_logo" class="selected-files"
                                        value="{{ get_setting('invoice_logo') }}">
                                </div>
                                <div class="file-preview"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Address') }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="invoice_address">
                                <input type="text" class="form-control" placeholder="{{ translate('Address') }}"
                                    name="invoice_address" value="{{ get_setting('invoice_address') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Email') }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="invoice_email">
                                <input type="text" class="form-control" placeholder="{{ translate('Email') }}"
                                    name="invoice_email" value="{{ get_setting('invoice_email') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Phone') }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="invoice_phone">
                                <input type="text" class="form-control" placeholder="{{ translate('Phone') }}"
                                    name="invoice_phone" value="{{ get_setting('invoice_phone') }}">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
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
