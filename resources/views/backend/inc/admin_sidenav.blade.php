<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @if (get_setting('system_logo_white') != null)
                    <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}"
                        class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100" src="{{ static_asset('assets/img/logo-white.png') }}"
                        class="brand-icon" alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <ul class="aiz-side-nav-list" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="aiz-side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="Path_18917" data-name="Path 18917"
                                d="M3.889,11.889H9.222A.892.892,0,0,0,10.111,11V3.889A.892.892,0,0,0,9.222,3H3.889A.892.892,0,0,0,3,3.889V11A.892.892,0,0,0,3.889,11.889Zm0,7.111H9.222a.892.892,0,0,0,.889-.889V14.556a.892.892,0,0,0-.889-.889H3.889A.892.892,0,0,0,3,14.556v3.556A.892.892,0,0,0,3.889,19Zm8.889,0h5.333A.892.892,0,0,0,19,18.111V11a.892.892,0,0,0-.889-.889H12.778a.892.892,0,0,0-.889.889v7.111A.892.892,0,0,0,12.778,19ZM11.889,3.889V7.444a.892.892,0,0,0,.889.889h5.333A.892.892,0,0,0,19,7.444V3.889A.892.892,0,0,0,18.111,3H12.778A.892.892,0,0,0,11.889,3.889Z"
                                transform="translate(-3 -3)" fill="#707070" />
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>

                <!-- Product -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_23" data-name="Group 23" transform="translate(-126 -590)">
                                <path id="Subtraction_31" data-name="Subtraction 31"
                                    d="M15,16H1a1,1,0,0,1-1-1V1A1,1,0,0,1,1,0H4.8V4.4a2,2,0,0,0,2,2H9.2a2,2,0,0,0,2-2V0H15a1,1,0,0,1,1,1V15A1,1,0,0,1,15,16Z"
                                    transform="translate(126 590)" fill="#707070" />
                                <path id="Rectangle_93" data-name="Rectangle 93"
                                    d="M0,0H4A0,0,0,0,1,4,0V4A1,1,0,0,1,3,5H1A1,1,0,0,1,0,4V0A0,0,0,0,1,0,0Z"
                                    transform="translate(132 590)" fill="#707070" />
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('Product') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        @can('show_products')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('product.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['product.index', 'product.create', 'product.edit', 'product_bulk_upload.index']) }}">
                                    <span class="aiz-side-nav-text">
                                        {{ addon_is_activated('multi_vendor') ? translate('Inhouse Products') : translate('Products') }}
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @if (addon_is_activated('multi_vendor'))
                            @can('show_seller_products')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.seller_products.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>
                                        @if (env('DEMO_MODE') == 'On')
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                        @endif
                        @can('show_categories')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('categories.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Category') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_brands')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('brands.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Brand') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_attributes')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('attributes.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index', 'attributes.edit', 'attributes.show', 'attribute_values.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Attributes') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_reviews')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('reviews.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Reviews') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <!-- Order -->
                @if (addon_is_activated('multi_vendor'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="Subtraction_32" data-name="Subtraction 32"
                                    d="M15,16H1a1,1,0,0,1-1-1V1A1,1,0,0,1,1,0H15a1,1,0,0,1,1,1V15A1,1,0,0,1,15,16ZM7,11a1,1,0,1,0,0,2h6a1,1,0,0,0,0-2ZM3,11a1,1,0,1,0,1,1A1,1,0,0,0,3,11ZM7,7A1,1,0,1,0,7,9h6a1,1,0,0,0,0-2ZM3,7A1,1,0,1,0,4,8,1,1,0,0,0,3,7ZM7,3A1,1,0,1,0,7,5h6a1,1,0,0,0,0-2ZM3,3A1,1,0,1,0,4,4,1,1,0,0,0,3,3Z"
                                    fill="#707070" />
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Orders') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('show_orders')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('orders.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['orders.index', 'orders.show']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Inhouse Orders') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_seller_orders')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.seller_orders.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Orders') }}</span>
                                        @if (env('DEMO_MODE') == 'On')
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @else
                    @can('show_orders')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('orders.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['orders.index', 'orders.show']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="Subtraction_32" data-name="Subtraction 32"
                                        d="M15,16H1a1,1,0,0,1-1-1V1A1,1,0,0,1,1,0H15a1,1,0,0,1,1,1V15A1,1,0,0,1,15,16ZM7,11a1,1,0,1,0,0,2h6a1,1,0,0,0,0-2ZM3,11a1,1,0,1,0,1,1A1,1,0,0,0,3,11ZM7,7A1,1,0,1,0,7,9h6a1,1,0,0,0,0-2ZM3,7A1,1,0,1,0,4,8,1,1,0,0,0,3,7ZM7,3A1,1,0,1,0,7,5h6a1,1,0,0,0,0-2ZM3,3A1,1,0,1,0,4,4,1,1,0,0,0,3,3Z"
                                        fill="#707070" />
                                </svg>
                                <span class="aiz-side-nav-text">{{ translate('Orders') }}</span>
                            </a>
                        </li>
                    @endcan
                @endif

                <!-- Customers -->
                @can('show_customers')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('customers.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['customers.index', 'customers.show']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                                <g id="Group_8860" data-name="Group 8860" transform="translate(30 -252)">
                                    <path id="Rectangle_16218" data-name="Rectangle 16218"
                                        d="M4,0H6a4,4,0,0,1,4,4V7a0,0,0,0,1,0,0H1A1,1,0,0,1,0,6V4A4,4,0,0,1,4,0Z"
                                        transform="translate(-30 259)" fill="#707070" />
                                    <circle id="Ellipse_612" data-name="Ellipse 612" cx="3" cy="3" r="3"
                                        transform="translate(-28 252)" fill="#707070" />
                                    <path id="Subtraction_33" data-name="Subtraction 33"
                                        d="M16,8H12V5a4.98,4.98,0,0,0-1.875-3.9A4.021,4.021,0,0,1,11,1h2a4.005,4.005,0,0,1,4,4V7A1,1,0,0,1,16,8Z"
                                        transform="translate(-31 258)" fill="#707070" />
                                    <path id="Subtraction_34" data-name="Subtraction 34"
                                        d="M10,7A3.013,3.013,0,0,1,7.584,5.778a4.008,4.008,0,0,0,0-3.557A3,3,0,1,1,10,7Z"
                                        transform="translate(-29 251)" fill="#707070" />
                                </g>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Seller -->
                @if (addon_is_activated('multi_vendor'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12.444" viewBox="0 0 14 12.444">
                                <path id="Path_25490" data-name="Path 25490"
                                    d="M4.985,6.083,5.6,2H2.4L1.063,5.5A1.227,1.227,0,0,0,1,5.889,1.82,1.82,0,0,0,3,7.444,1.9,1.9,0,0,0,4.985,6.083ZM8,7.444a1.82,1.82,0,0,0,2-1.556c0-.032,0-.064,0-.094L9.6,2H6.4L6,5.792c0,.032,0,.064,0,.1A1.82,1.82,0,0,0,8,7.444Zm3.889.814v3.075H4.111V8.263A3.273,3.273,0,0,1,3,8.456a3.206,3.206,0,0,1-.444-.038v4.938a1.091,1.091,0,0,0,1.087,1.089h8.713a1.093,1.093,0,0,0,1.089-1.089V8.418A3.342,3.342,0,0,1,13,8.456,3.232,3.232,0,0,1,11.889,8.258ZM14.938,5.5,13.6,2H10.4l.614,4.077A1.893,1.893,0,0,0,13,7.444a1.82,1.82,0,0,0,2-1.556A1.249,1.249,0,0,0,14.938,5.5Z"
                                    transform="translate(-1 -2)" fill="#707070" />
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Seller') }}</span>
                            @if (env('DEMO_MODE') == 'On')
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('show_sellers')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.all_sellers') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller.create', 'admin.seller.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_payouts')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.seller_payments_history') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_payout_requests')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.all_payout_requests') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_commission_log')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.commission_log.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Earning History') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_seller_packages')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.seller_packages.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_packages.create', 'admin.seller_packages.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_seller_package_payments')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.package_purchase_history') }}" class="aiz-side-nav-link ">
                                        <span class="aiz-side-nav-text">{{ translate('Package Payments') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif


                <!-- Refund -->
                @if (addon_is_activated('refund'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <svg id="Group_8930" data-name="Group 8930" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
                                <defs>
                                    <clipPath id="clip-path">
                                        <rect id="Rectangle_17178" data-name="Rectangle 17178" width="16" height="16"
                                            fill="#707070" />
                                    </clipPath>
                                </defs>
                                <g id="Group_23708" data-name="Group 23708" clip-path="url(#clip-path)">
                                    <path id="Subtraction_80" data-name="Subtraction 80"
                                        d="M-30-647a5.006,5.006,0,0,1-5-5,5.006,5.006,0,0,1,5-5,5.006,5.006,0,0,1,5,5A5.005,5.005,0,0,1-30-647Zm-1.637-3.979v.409a1.025,1.025,0,0,0,1.023,1.024h.191v.614h.819v-.614h.219a1.025,1.025,0,0,0,1.023-1.024v-.819a1.024,1.024,0,0,0-1.023-1.023h-1.229a.2.2,0,0,1-.2-.205v-.819a.2.2,0,0,1,.2-.2h1.229a.2.2,0,0,1,.205.2v.41h.818v-.41a1.024,1.024,0,0,0-1.023-1.023H-29.6v-.615h-.819v.615h-.191a1.024,1.024,0,0,0-1.023,1.023v.819a1.025,1.025,0,0,0,1.023,1.024h1.229a.205.205,0,0,1,.205.2v.819a.205.205,0,0,1-.205.205h-1.229a.2.2,0,0,1-.2-.205v-.409Z"
                                        transform="translate(38 660)" fill="#707070" />
                                    <path id="Path_26789" data-name="Path 26789"
                                        d="M14.378,3.171H16V1.891H12.18V4.732h1.28V4.085a6.718,6.718,0,1,1-2.691-2.206L11.3.713a8,8,0,1,0,3.082,2.459"
                                        transform="translate(0 0)" fill="#707070" />
                                </g>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Refund') }}</span>
                            @if (env('DEMO_MODE') == 'On')
                                <span class="badge badge-inline badge-danger">Addon</span>
                            @endif
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('show_refund_requests')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.refund_requests') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Refund Requests') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_refund_requests')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.refund_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Refund Settings') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                <!-- marketing -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                            <g id="Group_8862" data-name="Group 8862" transform="translate(30 -303)">
                                <path id="Rectangle_16222" data-name="Rectangle 16222"
                                    d="M0,0H2A0,0,0,0,1,2,0V3A1,1,0,0,1,1,4H1A1,1,0,0,1,0,3V0A0,0,0,0,1,0,0Z"
                                    transform="translate(-28 313)" fill="#707070" />
                                <path id="Rectangle_16223" data-name="Rectangle 16223"
                                    d="M1,0H4A0,0,0,0,1,4,0V6A0,0,0,0,1,4,6H1A1,1,0,0,1,0,5V1A1,1,0,0,1,1,0Z"
                                    transform="translate(-30 306)" fill="#707070" />
                                <path id="Path_18923" data-name="Path 18923" d="M0,0,5-2.044V7.97L0,6Z"
                                    transform="translate(-25 306)" fill="#707070" />
                                <path id="Rectangle_16225" data-name="Rectangle 16225"
                                    d="M0,0H0A2,2,0,0,1,2,2V2A2,2,0,0,1,0,4H0A0,0,0,0,1,0,4V0A0,0,0,0,1,0,0Z"
                                    transform="translate(-16 307)" fill="#707070" />
                                <rect id="Rectangle_16224" data-name="Rectangle 16224" width="2" height="12" rx="1"
                                    transform="translate(-19 303)" fill="#707070" />
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @can('show_offers')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('offers.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['offers.index', 'offers.create', 'offers.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Offers') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('send_newsletters')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('newsletters.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_subscribers')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_coupons')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('coupon.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['coupon.index', 'coupon.create', 'coupon.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @if (addon_is_activated('multi_vendor') && get_setting('conversation_system') == 1)
                    <!-- product query -->
                    @can('product_query')
                        @php
                            $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)
                                ->where('receiver_viewed', 0)
                                ->get();
                        @endphp
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('querries.index') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['querries.index', 'querries.show']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="Group_8863" data-name="Group 8863" transform="translate(-4 -4)">
                                        <path id="Path_18925" data-name="Path 18925"
                                            d="M18.4,4H5.6A1.593,1.593,0,0,0,4.008,5.6L4,20l3.2-3.2H18.4A1.6,1.6,0,0,0,20,15.2V5.6A1.6,1.6,0,0,0,18.4,4ZM7.2,9.6h9.6v1.6H7.2Zm6.4,4H7.2V12h6.4Zm3.2-4.8H7.2V7.2h9.6Z"
                                            fill="#707070" />
                                    </g>
                                </svg>
                                <span class="aiz-side-nav-text">{{ translate('Product Querries') }}</span>
                                @if (count($conversation) > 0)
                                    <span
                                        class="badge badge-inline badge-danger p-2">({{ count($conversation) }})</span>
                                @endif
                            </a>
                        </li>
                    @endcan
                    <!-- product query -->
                @endif


                <!-- Uploaded Files -->
                @can('show_uploaded_files')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('uploaded-files.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                <path id="Path_18924" data-name="Path 18924"
                                    d="M4.4,4.78v8.553A3.407,3.407,0,0,0,7.67,16.66l.23.007h6.18A2.1,2.1,0,0,1,12.1,18H7.2A4.1,4.1,0,0,1,3,14V6.667A2.01,2.01,0,0,1,4.4,4.78ZM14.9,2A2.052,2.052,0,0,1,17,4v9.333a2.052,2.052,0,0,1-2.1,2h-7a2.052,2.052,0,0,1-2.1-2V4A2.052,2.052,0,0,1,7.9,2Z"
                                    transform="translate(-3 -2)" fill="#707070" />
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                        </a>
                    </li>
                @endcan
                <!-- Support -->
                @can('show_chats')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('chats.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['chats.index', 'chats.show']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <g id="Group_8863" data-name="Group 8863" transform="translate(-4 -4)">
                                    <path id="Path_18925" data-name="Path 18925"
                                        d="M18.4,4H5.6A1.593,1.593,0,0,0,4.008,5.6L4,20l3.2-3.2H18.4A1.6,1.6,0,0,0,20,15.2V5.6A1.6,1.6,0,0,0,18.4,4ZM7.2,9.6h9.6v1.6H7.2Zm6.4,4H7.2V12h6.4Zm3.2-4.8H7.2V7.2h9.6Z"
                                        fill="#707070" />
                                </g>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Support chat') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Website Setup -->
                @can('website_setup')
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                                <g id="Group_8864" data-name="Group 8864" transform="translate(-24 -40)">
                                    <rect id="Rectangle_16227" data-name="Rectangle 16227" width="16" height="11" rx="1"
                                        transform="translate(24 40)" fill="#707070" />
                                    <rect id="Rectangle_16228" data-name="Rectangle 16228" width="6" height="1" rx="0.5"
                                        transform="translate(29 53)" fill="#707070" />
                                </g>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Website Setup') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.header') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Header') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.footer') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Footer') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.banners') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Banners') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.pages') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create', 'custom-pages.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Pages') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Appearance') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <!-- Setup & Configurations -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_8866" data-name="Group 8866" transform="translate(-3.185 -7)">
                                <path id="Path_18928" data-name="Path 18928"
                                    d="M13.688,20.6a6.064,6.064,0,0,0,1.331-.768l-.033.048,1.68.624a.826.826,0,0,0,1.015-.352l1.4-2.336a.79.79,0,0,0-.2-1.024L17.464,15.7l-.033.048a6.021,6.021,0,0,0,.083-.768,6.021,6.021,0,0,0-.083-.768l.033.048,1.414-1.088a.79.79,0,0,0,.2-1.024l-1.4-2.336a.845.845,0,0,0-1.015-.352l-1.68.624.033.048A7.559,7.559,0,0,0,13.688,9.4l-.283-1.728A.8.8,0,0,0,12.591,7H9.8a.8.8,0,0,0-.815.672L8.7,9.4a6.064,6.064,0,0,0-1.331.768L7.4,10.12,5.7,9.5a.826.826,0,0,0-1.015.352l-1.4,2.336a.79.79,0,0,0,.2,1.024L4.906,14.3l.033-.048A5.485,5.485,0,0,0,4.856,15a6.021,6.021,0,0,0,.083.768l-.033-.048L3.493,16.808a.79.79,0,0,0-.2,1.024l1.4,2.336A.845.845,0,0,0,5.7,20.52l1.68-.624-.017-.064A6.065,6.065,0,0,0,8.7,20.6l.283,1.712A.8.8,0,0,0,9.8,23h2.794a.8.8,0,0,0,.815-.672ZM7.867,15a3.329,3.329,0,1,1,3.326,3.2A3.275,3.275,0,0,1,7.867,15Z"
                                    transform="translate(0)" fill="#707070" />
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('Settings') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @if (addon_is_activated('multi_vendor'))
                            @can('show_shop_setting')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.shop_setting.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Shop Settings') }}</span>
                                        @if (env('DEMO_MODE') == 'On')
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                        @endif
                        @can('show_general_setting')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('general_setting.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('General Settings') }}</span>
                                </a>
                            </li>
                        @endcan
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('settings.otp') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('OTP Settings') }}</span>
                            </a>
                        </li>
                        @can('show_languages')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('languages.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Languages') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_currencies')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('currency.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Currency') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('smtp_setting')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('SMTP Settings') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('payment_method')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('payment_method.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payment Methods') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('file_system')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('File System Configuration') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('social_media_login')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Social media Logins') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('third_party_setting')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('third_party_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Third Party Settings') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('shipping_configuration')
                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Shipping') }}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>

                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('countries.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['countries.index', 'countries.edit', 'countries.update']) }}">
                                            <span
                                                class="aiz-side-nav-text">{{ translate('Shipping Countries') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('states.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['states.index', 'states.edit', 'states.update']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Shipping States') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('cities.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['cities.index', 'cities.edit', 'cities.update']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Shipping Cities') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('zones.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['zones.index', 'zones.create', 'zones.edit', 'zones.update']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Shipping Zones') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('show_taxes')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('taxes.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['taxes.index', 'taxes.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Tax') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>


                <!-- Staffs -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16.001" viewBox="0 0 14 16.001">
                            <g id="Group_8868" data-name="Group 8868" transform="translate(30 -384)">
                                <rect id="Rectangle_16229" data-name="Rectangle 16229" width="8" height="8" rx="4"
                                    transform="translate(-27 384)" fill="#707070" />
                                <path id="Subtraction_35" data-name="Subtraction 35"
                                    d="M6,7H1A1,1,0,0,1,0,6,6.007,6.007,0,0,1,6,0H8a6.007,6.007,0,0,1,6,6,1,1,0,0,1-1,1H8V3A1,1,0,1,0,6,3V7Z"
                                    transform="translate(-30 393)" fill="#707070" />
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('Staffs') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @can('show_staffs')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('staffs.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Staffs') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('show_staff_roles')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('roles.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Roles') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @canany(['system_update', 'server_status'])
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14">
                                <g id="Group_8869" data-name="Group 8869" transform="translate(-24 -40)">
                                    <path id="Subtraction_36" data-name="Subtraction 36"
                                        d="M5-525H-9a1,1,0,0,1-1-1v-9a1,1,0,0,1,1-1H5a1,1,0,0,1,1,1v9A1,1,0,0,1,5-525Zm-5.476-9.5a2.5,2.5,0,0,0-1.76.725,2.5,2.5,0,0,0-.651,2.339L-5.624-528.7a1.3,1.3,0,0,0,0,1.825,1.291,1.291,0,0,0,.913.376,1.292,1.292,0,0,0,.912-.376l2.736-2.74a2.489,2.489,0,0,0,.585.07,2.5,2.5,0,0,0,1.754-.719,2.508,2.508,0,0,0,.6-2.541l-.653.653-.408.405a1.1,1.1,0,0,1-.783.325,1.1,1.1,0,0,1-.783-.325,1.1,1.1,0,0,1-.325-.785,1.1,1.1,0,0,1,.325-.782l.4-.408.653-.653a2.481,2.481,0,0,0-.78-.125Z"
                                        transform="translate(34 576)" fill="#707070" />
                                    <rect id="Rectangle_16228" data-name="Rectangle 16228" width="6" height="1" rx="0.5"
                                        transform="translate(29 53)" fill="#707070" />
                                </g>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('System') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('system_update')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('system_update') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Update') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('server_status')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('server_status') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Server status') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <!-- Addon Manager -->
                @can('show_addons')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('addons.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.003" viewBox="0 0 16 16.003">
                                <path id="Path_18944" data-name="Path 18944"
                                    d="M2,17.112V13.556H3.778A1.779,1.779,0,0,0,5.532,11.48,1.844,1.844,0,0,0,3.68,10H2V6.445a.889.889,0,0,1,.889-.89H6.445V3.777a1.779,1.779,0,0,1,2.08-1.754A1.844,1.844,0,0,1,10,3.873v1.68h3.556a.89.89,0,0,1,.89.89V10h1.68a1.844,1.844,0,0,1,1.849,1.479,1.779,1.779,0,0,1-1.754,2.076H14.446v3.556a.889.889,0,0,1-.89.889H10.89V16.223a1.779,1.779,0,0,0-2.08-1.754,1.844,1.844,0,0,0-1.475,1.851V18H2.889A.888.888,0,0,1,2,17.112Z"
                                    transform="translate(-2 -1.998)" fill="#707070" />
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Addon Manager') }}</span>
                        </a>
                    </li>
                @endcan
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
