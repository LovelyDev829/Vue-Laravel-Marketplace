@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3">{{ translate('Website Banners') }}</h1>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="fw-600 mb-0">{{ translate('Banners') }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Login page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 520x475' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="login_page_banner">
                            <input type="hidden" name="login_page_banner" class="selected-files" value="{{ get_setting('login_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="login_page_banner_link">
                    <input type="text" placeholder="" name="login_page_banner_link" value="{{ get_setting('login_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Registration page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 520x720' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="registration_page_banner">
                            <input type="hidden" name="registration_page_banner" class="selected-files" value="{{ get_setting('registration_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="registration_page_banner_link">
                    <input type="text" placeholder="" name="registration_page_banner_link" value="{{ get_setting('registration_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Forgot password page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 520x435' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="forgot_page_banner">
                            <input type="hidden" name="forgot_page_banner" class="selected-files" value="{{ get_setting('forgot_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="forgot_page_banner_link">
                    <input type="text" placeholder="" name="forgot_page_banner_link" value="{{ get_setting('forgot_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Product listing page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 1300x80' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="listing_page_banner">
                            <input type="hidden" name="listing_page_banner" class="selected-files" value="{{ get_setting('listing_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="listing_page_banner_link">
                    <input type="text" placeholder="" name="listing_page_banner_link" value="{{ get_setting('listing_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Product details page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 200x200' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="product_page_banner">
                            <input type="hidden" name="product_page_banner" class="selected-files" value="{{ get_setting('product_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="product_page_banner_link">
                    <input type="text" placeholder="" name="product_page_banner_link" value="{{ get_setting('product_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Checkout page banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 300x315' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="checkout_page_banner">
                            <input type="hidden" name="checkout_page_banner" class="selected-files" value="{{ get_setting('checkout_page_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="checkout_page_banner_link">
                    <input type="text" placeholder="" name="checkout_page_banner_link" value="{{ get_setting('checkout_page_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Customer dashboard top banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 1025x120' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="dashboard_page_top_banner">
                            <input type="hidden" name="dashboard_page_top_banner" class="selected-files" value="{{ get_setting('dashboard_page_top_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="dashboard_page_top_banner_link">
                    <input type="text" placeholder="" name="dashboard_page_top_banner_link" value="{{ get_setting('dashboard_page_top_banner_link') }}" class="form-control">
                </div>
            </div>
            <div class="form-group row gutters-10">
                <div class="col-lg-3">
                    <label class="from-label d-block">{{translate('Customer dashboard bottom banner & link')}}</label>
                    <small>{{ translate('Recommended size').' 315x425' }}</small>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="dashboard_page_bottom_banner">
                            <input type="hidden" name="dashboard_page_bottom_banner" class="selected-files" value="{{ get_setting('dashboard_page_bottom_banner') }}">
                        </div>
                        <div class="file-preview box sm"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input type="hidden" name="types[]" value="dashboard_page_bottom_banner_link">
                    <input type="text" placeholder="" name="dashboard_page_bottom_banner_link" value="{{ get_setting('dashboard_page_bottom_banner_link') }}" class="form-control">
                </div>
            </div>
            @if (addon_is_activated('multi_vendor'))
                <div class="form-group row gutters-10">
                    <div class="col-lg-3">
                        <label class="from-label d-block">{{translate('All shops page banner & link')}}</label>
                        <small>{{ translate('Recommended size').' 315x425' }}</small>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="all_shops_page_banner">
                                <input type="hidden" name="all_shops_page_banner" class="selected-files" value="{{ get_setting('all_shops_page_banner') }}">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <input type="hidden" name="types[]" value="all_shops_page_banner_link">
                        <input type="text" placeholder="" name="all_shops_page_banner_link" value="{{ get_setting('all_shops_page_banner_link') }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row gutters-10">
                    <div class="col-lg-3">
                        <label class="from-label d-block">{{translate('Shop registration page banner & link')}}</label>
                        <small>{{ translate('Recommended size').' 315x425' }}</small>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="shop_registration_page_banner">
                                <input type="hidden" name="shop_registration_page_banner" class="selected-files" value="{{ get_setting('shop_registration_page_banner') }}">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <input type="hidden" name="types[]" value="shop_registration_page_banner_link">
                        <input type="text" placeholder="" name="shop_registration_page_banner_link" value="{{ get_setting('shop_registration_page_banner_link') }}" class="form-control">
                    </div>
                </div>
            @endif
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection