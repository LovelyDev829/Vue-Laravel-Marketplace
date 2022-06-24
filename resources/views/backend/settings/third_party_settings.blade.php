@extends('backend.layouts.app')

@section('content')

    {{-- Facebook Chat Setting --}}
    <div class="card">
    	<div class="card-header">
    		<h6 class="fw-600 mb-0">{{ translate('Facebook Chat') }}</h6>
    	</div>
    	<div class="card-body">
    		<div class="row gutters-10">
    			<div class="col-lg-6">
    				<div class="card shadow-none bg-light">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Facebook Chat Setting')}}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('facebook_chat.update') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-from-label">{{translate('Facebook Chat')}}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input value="1" name="facebook_chat" type="checkbox" @if (get_setting('facebook_chat') == 1)
                                                checked
                                            @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" name="types[]" value="FACEBOOK_PAGE_ID">
                                    <div class="col-md-3">
                                        <label class="col-from-label">{{translate('Facebook Page ID')}}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="FACEBOOK_PAGE_ID" value="{{  env('FACEBOOK_PAGE_ID') }}" placeholder="{{ translate('Facebook Page ID') }}" required>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                </div>
                            </form>
                        </div>
    				</div>
    			</div>
    			<div class="col-lg-6">
                    <div class="card shadow-none bg-light">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.') }}</h5>
                        </div>
                          <div class="card-body">
                              <ul class="list-group mar-no">
                                  <li class="list-group-item text-dark">1. {{ translate('Login into your facebook page') }}</li>
                                  <li class="list-group-item text-dark">2. {{ translate('Find the About option of your facebook page') }}.</li>
                                  <li class="list-group-item text-dark">3. {{ translate('At the very bottom, you can find the \“Facebook Page ID\”') }}.</li>
                                  <li class="list-group-item text-dark">4. {{ translate('Go to Settings of your page and find the option of \"Advance Messaging\"') }}.</li>
                                  <li class="list-group-item text-dark">5. {{ translate('Scroll down that page and you will get \"white listed domain\"') }}.</li>
                                  <li class="list-group-item text-dark">6. {{ translate('Set your website domain name') }}.</li>
                              </ul>
                          </div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    {{-- Facebook Pixel Setting--}}
    <div class="card">
    	<div class="card-header">
    		<h6 class="fw-600 mb-0">{{ translate('Facebook Pixel') }}</h6>
    	</div>
    	<div class="card-body">
    		<div class="row gutters-10">
    			<div class="col-lg-6">
    				<div class="card shadow-none bg-light">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Facebook Pixel Setting') }}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('facebook_pixel.update') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-from-label">{{ translate('Facebook Pixel') }}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input value="1" name="facebook_pixel" type="checkbox" @if (get_setting('facebook_pixel') == 1)
                                                checked
                                            @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" name="types[]" value="FACEBOOK_PIXEL_ID">
                                    <div class="col-lg-3">
                                        <label class="col-from-label">{{ translate('Facebook Pixel ID') }}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="FACEBOOK_PIXEL_ID" value="{{  env('FACEBOOK_PIXEL_ID') }}" placeholder="{{ translate('Facebook Pixel ID') }}" required>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                </div>
                            </form>
                        </div>
    				</div>
    			</div>
    			<div class="col-lg-6">
                    <div class="card shadow-none bg-light">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Please be carefull when you are configuring Facebook pixel.') }}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group mar-no">
                                <li class="list-group-item text-dark">1. {{ translate('Log in to Facebook and go to your Ads Manager account') }}.</li>
                                <li class="list-group-item text-dark">2. {{ translate('Open the Navigation Bar and select Events Manager') }}.</li>
                                <li class="list-group-item text-dark">3. {{ translate('Copy your Pixel ID from underneath your Site Name and paste the number into Facebook Pixel ID field') }}.</li>
                            </ul>
                        </div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Google Analytics Setting')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('google_analytics.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Google Analytics')}}</label>
                            </div>
                            <div class="col-md-7">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="google_analytics" type="checkbox" @if (get_setting('google_analytics') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="TRACKING_ID">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Tracking ID')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="TRACKING_ID" value="{{  env('TRACKING_ID') }}" placeholder="{{ translate('Tracking ID') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6">{{translate('Google reCAPTCHA Setting')}}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('google_recaptcha.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="control-label">{{translate('Google reCAPTCHA')}}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="google_recaptcha" type="checkbox" @if (get_setting('google_recaptcha') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="CAPTCHA_KEY">
                            <div class="col-md-4">
                                <label class="control-label">{{translate('Site KEY')}}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="CAPTCHA_KEY" value="{{  env('CAPTCHA_KEY') }}" placeholder="{{ translate('Site KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>

@endsection
