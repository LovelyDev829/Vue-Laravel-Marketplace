@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('Login/Registration Setting')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{translate('Login/Registration with')}}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="customer_login_with">
                                <div class="aiz-radio-list">
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_login_with" value="email" @if(get_setting('customer_login_with') == 'email') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Email') }}</span>
                                    </label>
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_login_with" value="phone" @if(get_setting('customer_login_with') == 'phone') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Phone') }}</span>
                                    </label>
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_login_with" value="email_phone" @if(get_setting('customer_login_with') == 'email_phone') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Email & Phone') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="col-from-label">{{translate('OTP vertification with')}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="customer_otp_with">
                                <div class="aiz-radio-list">
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_otp_with" value="email" @if(get_setting('customer_otp_with') == 'email') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Email') }}</span>
                                    </label>
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_otp_with" value="phone" @if(get_setting('customer_otp_with') == 'phone') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Phone') }}</span>
                                    </label>
                                    <label class="aiz-radio">
                                        <input type="radio" name="customer_otp_with" value="disabled" @if(get_setting('customer_otp_with') == 'disabled') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Disabled') }}</span>
                                    </label>
                                </div>
                                <div class="alert alert-info">
                                    <ul class="pl-3">
                                        <li>{{ translate("If you select disabled, then customers can register and access their panel. The don't need to verify.") }}</li>
                                        <li>{{ translate("If you select Login/Registration with email, then customers need to verify their email.") }}</li>
                                        <li>{{ translate("If you select Login/Registration with phone, then customers need to verify their phone.") }}</li>
                                        <li>{{ translate("If you select Login/Registration with email & phone, then customers need to verify their phone or email based on this selected option.") }}</li>
                                        <li>{{ translate("If you use phone verification or login with phone only, make sure you've configured any sms gateway properly.") }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{translate('Active sms gateway')}}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="active_sms_gateway">
                                <div class="aiz-radio-list">
                                    <label class="aiz-radio">
                                        <input type="radio" name="active_sms_gateway" value="twilio" @if(get_setting('active_sms_gateway') == 'twilio') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Twilio') }}</span>
                                    </label>
                                    <label class="aiz-radio">
                                        <input type="radio" name="active_sms_gateway" value="vonage" @if(get_setting('active_sms_gateway') == 'vonage') checked @endif>
                                        <span class="aiz-rounded-check"></span>
                                        <span>{{ translate('Vonage') }}</span>
                                    </label>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Twilio Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="TWILIO_SID">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('TWILIO SID')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="TWILIO_SID" value="{{  env('TWILIO_SID') }}" placeholder="TWILIO SID" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="TWILIO_AUTH_TOKEN">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('TWILIO AUTH TOKEN')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="TWILIO_AUTH_TOKEN" value="{{  env('TWILIO_AUTH_TOKEN') }}" placeholder="TWILIO AUTH TOKEN" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="VALID_TWILLO_NUMBER">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('VALID TWILIO NUMBER')}}</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="VALID_TWILLO_NUMBER" value="{{  env('VALID_TWILLO_NUMBER') }}" placeholder="VALID TWILLO NUMBER" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6 ">{{ translate('Vonage Credential') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="VONAGE_KEY">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('VONAGE KEY')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="VONAGE_KEY" value="{{  env('VONAGE_KEY') }}" placeholder="VONAGE KEY" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="VONAGE_SECRET">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('VONAGE SECRET')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="VONAGE_SECRET" value="{{  env('VONAGE_SECRET') }}" placeholder="VONAGE SECRET" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection