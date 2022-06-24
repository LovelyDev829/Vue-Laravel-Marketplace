@extends('backend.layouts.app')

@section('content')
    @if (env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
        <div class="">
            <div class="alert alert-danger d-flex align-items-center">
                {{ translate('Please Configure SMTP Setting to work all email sending functionality') }},
                <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
            </div>
        </div>
    @endif

    @can('show_dashboard')

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-between align-items-end"
                    style="background-color: #91A8D0">
                    <div class="pb-5">
                        <div class="fw-500">{{ translate('Total Customers') }}</div>
                        <div class="h2 fw-700">{{ \App\Models\User::where('user_type', 'customer')->count() }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64.001" viewBox="0 0 64 64.001">
                        <g id="Group_8872" data-name="Group 8872" transform="translate(330 100)" opacity="0.5">
                            <path id="Union_27" data-name="Union 27"
                                d="M48,34V25h2v9ZM0,34V25A24.993,24.993,0,0,1,42.678,7.322,24.924,24.924,0,0,1,50,25H48A23,23,0,1,0,2,25v9Z"
                                transform="translate(-330 -70)" fill="#fff" />
                            <path id="Subtraction_44" data-name="Subtraction 44"
                                d="M68,38H66V29A23.046,23.046,0,0,0,47.136,6.369a29.165,29.165,0,0,0-3.414-2.36A24.98,24.98,0,0,1,68,29h0v9Z"
                                transform="translate(-334 -74)" fill="#fff" />
                            <path id="Subtraction_38" data-name="Subtraction 38"
                                d="M13,26A13,13,0,0,1,3.808,3.808,13,13,0,1,1,22.192,22.192,12.915,12.915,0,0,1,13,26ZM13,2A11,11,0,1,0,24,13,11.012,11.012,0,0,0,13,2Z"
                                transform="translate(-318 -100)" fill="#fff" />
                            <path id="Subtraction_43" data-name="Subtraction 43"
                                d="M31,30a13.156,13.156,0,0,1-2.717-.283A17.155,17.155,0,0,0,30,27.955c.329.03.665.045,1,.045A11,11,0,1,0,31,6c-.333,0-.669.015-1,.045a17.153,17.153,0,0,0-1.718-1.762A13.148,13.148,0,0,1,31,4a13,13,0,0,1,9.193,22.193A12.915,12.915,0,0,1,31,30Z"
                                transform="translate(-322 -104)" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-between align-items-end"
                    style="background-color: #F0C05A">
                    <div class="pb-5">
                        <div class="fw-500">{{ translate('Total Products') }}</div>
                        <div class="h2 fw-700">{{ \App\Models\Product::count() }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64.001" viewBox="0 0 64 64.001">
                        <path id="Union_29" data-name="Union 29"
                            d="M64,64H0V0H64V64h0ZM2,62H62V2H2ZM25,23V21H37V2h2V23Zm0-2V2h2V21Z" fill="#fff" opacity="0.5" />
                    </svg>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-between align-items-end"
                    style="background-color: #7BC4C4">
                    <div class="pb-5">
                        <div class="fw-500">{{ translate('Total Orders') }}</div>
                        <div class="h2 fw-700">{{ \App\Models\Order::count() }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">
                        <path id="Union_30" data-name="Union 30"
                            d="M56,62a6.011,6.011,0,0,0,5.657-4H28.747a8.014,8.014,0,0,1-2.461,4H56v2H22q-.252,0-.5-.016Q21.252,64,21,64v-.062A8.012,8.012,0,0,1,14,56h2a6.008,6.008,0,0,0,5.5,5.98A6.008,6.008,0,0,0,27,56H64a8.009,8.009,0,0,1-8,8Zm-8-6V8h0a6.008,6.008,0,0,0-6-6h0V0a8.009,8.009,0,0,1,8,8V56ZM14,56V8H0A8.009,8.009,0,0,1,8,0H42V2H13.286A7.984,7.984,0,0,1,16,8V56ZM13.657,6A6.011,6.011,0,0,0,8,2H8A6.011,6.011,0,0,0,2.343,6ZM28,49V47H44v2Zm0-4V43H44v2Zm-8,0V43h4v2Zm8-6V37H44v2Zm0-4V33H44v2Zm-8,0V33h4v2Zm8-6V27H44v2Zm0-4V23H44v2Zm-8,0V23h4v2Zm8-6V17H44v2Zm0-4V13H44v2Zm-8,0V13h4v2Z"
                            fill="#fff" opacity="0.5" />
                    </svg>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-between align-items-end"
                    style="background-color: #FF6F61">
                    <div class="pb-5">
                        <div class="fw-500">{{ translate('Total Sales') }}</div>
                        <div class="h2 fw-700">
                            {{ format_price(\App\Models\Order::where('delivery_status', '!=', 'cancelled')->sum('grand_total'), true) }}
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64.002" height="64" viewBox="0 0 64.002 64">
                        <g id="Group_8873" data-name="Group 8873" transform="translate(-1801.1 -206)" opacity="0.5">
                            <path id="Path_18946" data-name="Path 18946"
                                d="M29.022,34.545a10.117,10.117,0,0,0-1.18-5.14,11.161,11.161,0,0,0-3.985-3.739,44.893,44.893,0,0,0-8.3-3.606,35.052,35.052,0,0,1-8.09-3.694,11.715,11.715,0,0,1-3.848-4.19A12.449,12.449,0,0,1,2.376,8.36,11.576,11.576,0,0,1,6.036-.585,14.312,14.312,0,0,1,15.579-4.16v-6.4h1.881v6.4q6.294.342,9.715,4.19T30.6,10.515H28.749a13.168,13.168,0,0,0-3.3-9.355,11.723,11.723,0,0,0-9.013-3.54A12.837,12.837,0,0,0,7.558.6a9.839,9.839,0,0,0-3.335,7.7,10.722,10.722,0,0,0,1.112,5.3,10.348,10.348,0,0,0,3.694,3.54,37.464,37.464,0,0,0,7.269,3.2,61.714,61.714,0,0,1,7.183,2.856,15.758,15.758,0,0,1,4.139,2.89,10.806,10.806,0,0,1,2.446,3.66,12.813,12.813,0,0,1,.8,4.755,11.6,11.6,0,0,1-3.54,8.808,14.468,14.468,0,0,1-9.492,3.711v6.431H15.956v-6.4Q8.7,46.774,4.736,42.925T.768,32.339H2.615q0,6.038,3.78,9.45T16.674,45.2a12.91,12.91,0,0,0,8.859-3.073A9.71,9.71,0,0,0,29.022,34.545Z"
                                transform="translate(1834.232 216.556)" fill="#fff" />
                            <path id="Path_18947" data-name="Path 18947"
                                d="M29.022,34.545a10.117,10.117,0,0,0-1.18-5.14,11.161,11.161,0,0,0-3.985-3.739,44.893,44.893,0,0,0-8.3-3.606,35.052,35.052,0,0,1-8.09-3.694,11.715,11.715,0,0,1-3.848-4.19A12.449,12.449,0,0,1,2.376,8.36,11.576,11.576,0,0,1,6.036-.585,14.312,14.312,0,0,1,15.579-4.16v-6.4h1.881v6.4q6.294.342,9.715,4.19T30.6,10.515H28.749a13.168,13.168,0,0,0-3.3-9.355,11.723,11.723,0,0,0-9.013-3.54A12.837,12.837,0,0,0,7.558.6a9.839,9.839,0,0,0-3.335,7.7,10.722,10.722,0,0,0,1.112,5.3,10.348,10.348,0,0,0,3.694,3.54,37.464,37.464,0,0,0,7.269,3.2,61.714,61.714,0,0,1,7.183,2.856,15.758,15.758,0,0,1,4.139,2.89,10.806,10.806,0,0,1,2.446,3.66,12.813,12.813,0,0,1,.8,4.755,11.6,11.6,0,0,1-3.54,8.808,14.468,14.468,0,0,1-9.492,3.711v6.431H15.956v-6.4Q8.7,46.774,4.736,42.925T.768,32.339H2.615q0,6.038,3.78,9.45T16.674,45.2a12.91,12.91,0,0,0,8.859-3.073A9.71,9.71,0,0,0,29.022,34.545Z"
                                transform="translate(1800.332 216.556)" fill="#fff" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="rounded-lg mb-4" style="background-color: #FF6F61">
                    <div class="px-4 pt-4 pb-3 text-white fs-16 fw-700">{{ translate('Order stat') }}</div>
                    <canvas id="graph-1" class="w-100" height="155"></canvas>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="rounded-lg p-3 d-flex align-items-center border mb-4 bg-light">
                            <div class="flex-grow-1 py-5px">
                                <div class="fs-20 fw-700 opacity-90">{{ \App\Models\Category::count() }}</div>
                                <div class="opacity-60">{{ translate('Total Category') }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path id="Path_18951" data-name="Path 18951"
                                    d="M20.358,12.949A3.691,3.691,0,0,1,24,16.656h0v3.627A3.7,3.7,0,0,1,20.358,24H16.805a3.692,3.692,0,0,1-3.631-3.718h0V16.656a3.669,3.669,0,0,1,3.631-3.706h3.553Zm-15.257,0a.974.974,0,0,1,.935.464,1.018,1.018,0,0,1,0,1.062.974.974,0,0,1-.935.464H3.642a1.71,1.71,0,0,0-1.693,1.717h0v3.581a1.744,1.744,0,0,0,1.693,1.717H7.217a1.664,1.664,0,0,0,1.2-.5,1.735,1.735,0,0,0,.5-1.218h0V14.859l-.015-.134a1.007,1.007,0,0,1,.454-.893.963.963,0,0,1,1.1.033,1.011,1.011,0,0,1,.38,1.051h0v5.355a3.68,3.68,0,0,1-3.642,3.718H3.642A3.759,3.759,0,0,1,0,20.271H0V16.656a3.746,3.746,0,0,1,1.067-2.625,3.593,3.593,0,0,1,2.574-1.082H5.1Zm15.257,1.99H16.805a1.7,1.7,0,0,0-1.682,1.717h0v3.627a1.724,1.724,0,0,0,.489,1.217,1.653,1.653,0,0,0,1.192.5h3.553a1.653,1.653,0,0,0,1.192-.5,1.724,1.724,0,0,0,.489-1.217h0V16.656a1.735,1.735,0,0,0-.493-1.214,1.664,1.664,0,0,0-1.189-.5ZM20.358,0a3.759,3.759,0,0,1,3.631,3.718h0V7.333a3.748,3.748,0,0,1-1.032,2.634A3.6,3.6,0,0,1,20.4,11.085h-1.47a1,1,0,0,1,0-1.99h1.425a1.676,1.676,0,0,0,1.2-.518,1.747,1.747,0,0,0,.484-1.233h0V3.718A1.722,1.722,0,0,0,20.358,2H16.805a1.7,1.7,0,0,0-1.682,1.717h0V9.141l-.012.125a1,1,0,0,1-.991.853.96.96,0,0,1-.683-.31,1,1,0,0,1-.264-.713h0V3.718A3.746,3.746,0,0,1,14.234,1.09,3.593,3.593,0,0,1,16.805,0h3.553ZM7.194,0a3.692,3.692,0,0,1,3.642,3.718h0V7.344A3.746,3.746,0,0,1,9.769,9.969a3.593,3.593,0,0,1-2.574,1.082H3.642A3.691,3.691,0,0,1,0,7.344H0V3.718A3.7,3.7,0,0,1,3.642,0H7.194Zm0,2H3.642a1.663,1.663,0,0,0-1.211.491,1.735,1.735,0,0,0-.5,1.226h0V7.344a1.736,1.736,0,0,0,.492,1.248,1.664,1.664,0,0,0,1.223.5H7.194a1.676,1.676,0,0,0,1.2-.518,1.747,1.747,0,0,0,.484-1.233h0V3.718A1.711,1.711,0,0,0,7.194,2Z"
                                    fill="#7bc4c4" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-lg p-3 d-flex align-items-center border mb-4 bg-light">
                            <div class="flex-grow-1 py-5px">
                                <div class="fs-20 fw-700 opacity-90">{{ \App\Models\Brand::count() }}</div>
                                <div class="opacity-60">{{ translate('Total Brands') }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="23.999" viewBox="0 0 24 23.999">
                                <g id="Group_8915" data-name="Group 8915" transform="translate(-640 -606)">
                                    <path id="Union_34" data-name="Union 34"
                                        d="M-618-600c0-.012,0-.023,0-.035A4,4,0,0,0-622-604h-17a1,1,0,0,1-1-1,1,1,0,0,1,1-1h17a6.007,6.007,0,0,1,6,6h0a1,1,0,0,1-1,1A1,1,0,0,1-618-600Z"
                                        transform="translate(1280 1212)" fill="#ff6f61" />
                                    <path id="Union_36" data-name="Union 36"
                                        d="M22,6c0-.012,0-.023,0-.035A4,4,0,0,0,18,2H1A1,1,0,0,1,1,0H18a6.007,6.007,0,0,1,6,6h0a1,1,0,1,1-2,0Z"
                                        transform="translate(664 629.999) rotate(180)" fill="#ff6f61" />
                                    <path id="Subtraction_79" data-name="Subtraction 79"
                                        d="M6,12a6,6,0,1,1,6-6A6.007,6.007,0,0,1,6,12ZM6,2a4,4,0,1,0,4,4A4.005,4.005,0,0,0,6,2Z"
                                        transform="translate(646 612)" fill="#ff6f61" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-lg p-3 d-flex align-items-center border mb-4 bg-light">
                            <div class="flex-grow-1 py-5px">
                                <div class="fs-20 fw-700 opacity-90">{{ \App\Models\Coupon::count() }}</div>
                                <div class="opacity-60">{{ translate('Coupons') }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_8909" data-name="Group 8909" transform="translate(-9.875 -11)">
                                    <g id="Icon-Tag" transform="translate(9.875 11)">
                                        <path id="Fill-129"
                                            d="M-58.8-347a2.712,2.712,0,0,1-1.937-.8l-7.577-7.582a2.72,2.72,0,0,1,0-3.876L-58.172-369.4a6.045,6.045,0,0,1,3.817-1.6h6.495a2.774,2.774,0,0,1,2.735,2.736v6.5a6.052,6.052,0,0,1-1.6,3.819L-56.862-347.8a2.712,2.712,0,0,1-1.937.8Zm4.444-22.289a4.482,4.482,0,0,0-2.621,1.083L-67.117-358.06a1,1,0,0,0,0,1.425l7.577,7.582a1,1,0,0,0,1.424,0L-47.974-359.2a4.341,4.341,0,0,0,1.082-2.622v-6.5a1.022,1.022,0,0,0-1.026-1.026h-6.438Z"
                                            transform="translate(69.125 371)" fill="#91a8d0" />
                                        <path id="Fill-130"
                                            d="M-41.539-358.177a3.368,3.368,0,0,1-3.361-3.361,3.368,3.368,0,0,1,3.361-3.361,3.368,3.368,0,0,1,3.361,3.361,3.368,3.368,0,0,1-3.361,3.361Zm0-5.128a1.775,1.775,0,0,0-1.766,1.766,1.775,1.775,0,0,0,1.766,1.766,1.775,1.775,0,0,0,1.766-1.766,1.775,1.775,0,0,0-1.766-1.766Z"
                                            transform="translate(58.702 368.375)" fill="#91a8d0" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-lg p-3 d-flex align-items-center border mb-4 bg-light">
                            <div class="flex-grow-1 py-5px">
                                <div class="fs-20 fw-700 opacity-90">{{ \App\Models\Offer::count() }}</div>
                                <div class="opacity-60">{{ translate('Offers') }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.53" height="24" viewBox="0 0 19.53 24">
                                <path id="Path_18950" data-name="Path 18950"
                                    d="M8.932,9.023l0,0,0,0Zm10.8-.2a1.342,1.342,0,0,0-.25-.19,1.085,1.085,0,0,0-1.518.446,6.273,6.273,0,0,1-1.517,1.928,9.457,9.457,0,0,0-4.63-9.864,1.085,1.085,0,0,0-1.618.874A7.613,7.613,0,0,1,7.519,7.377l-.25.2A9.236,9.236,0,0,0,5.113,9.6a9.747,9.747,0,0,0,3.966,15.09,1.084,1.084,0,0,0,1.494-1,1.139,1.139,0,0,0-.054-.339,7.57,7.57,0,0,1-.206-2.8,9.769,9.769,0,0,0,4.679,4.358,1.082,1.082,0,0,0,.776.041A9.759,9.759,0,0,0,19.732,8.82ZM15.5,22.742a7.556,7.556,0,0,1-3.881-4.776,9.665,9.665,0,0,1-.195-1.046A1.085,1.085,0,0,0,10.553,16a1.065,1.065,0,0,0-.208-.02,1.084,1.084,0,0,0-.94.544A9.72,9.72,0,0,0,8.1,21.645,7.579,7.579,0,0,1,6.822,10.938,7.111,7.111,0,0,1,8.516,9.357.808.808,0,0,0,8.6,9.3s.322-.266.333-.272A9.73,9.73,0,0,0,12.075,4a7.309,7.309,0,0,1,1.5,8.775,1.085,1.085,0,0,0,1.284,1.538,8.523,8.523,0,0,0,4.19-2.916A7.6,7.6,0,0,1,15.5,22.742Z"
                                    transform="translate(-3 -1)" fill="#d94f70" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="rounded-lg p-4 border mb-4 bg-light">
                    <div class="py-2 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="23.999" viewBox="0 0 23.999 23.999">
                            <g id="Group_8914" data-name="Group 8914" transform="translate(-2.25 -2.25)">
                                <path id="Path_18961" data-name="Path 18961"
                                    d="M22.071,26.249H6.436A4.186,4.186,0,0,1,2.25,22.063V6.428A4.186,4.186,0,0,1,6.436,2.25H22.071a4.178,4.178,0,0,1,4.178,4.178V22.063a4.186,4.186,0,0,1-4.178,4.186ZM6.436,4.217A2.211,2.211,0,0,0,4.217,6.428V22.063a2.219,2.219,0,0,0,2.219,2.219H22.071a2.211,2.211,0,0,0,2.211-2.219V6.428a2.211,2.211,0,0,0-2.211-2.211Z"
                                    fill="#f0c05a" />
                                <path id="Path_18962" data-name="Path 18962"
                                    d="M12.5,15.233a1.9,1.9,0,0,1-.787-.173,1.959,1.959,0,0,1-1.149-1.8V3.234a.984.984,0,1,1,1.967,0V13.258l1.849-1.637a1.9,1.9,0,0,1,2.526,0l1.9,1.645L18.743,3.234a.984.984,0,0,1,1.967,0V13.258a1.959,1.959,0,0,1-1.149,1.8,1.9,1.9,0,0,1-2.054-.307l-1.873-1.621-1.873,1.629a1.9,1.9,0,0,1-1.259.472ZM15.6,13.109ZM15.674,13.109Zm1.141,8.278H9.734a.984.984,0,1,1,0-1.967h7.082a.984.984,0,1,1,0,1.967Z"
                                    transform="translate(-1.385)" fill="#f0c05a" />
                            </g>
                        </svg>
                        <div class="flex-grow-1 fw-700 mx-4">{{ translate('Order Placed') }}</div>
                        <div class="fs-20 fw-600" style="color: #F0C05A">
                            {{ \App\Models\Order::where('delivery_status', 'order_placed')->count() }}</div>
                    </div>
                </div>
                <div class="rounded-lg p-4 border mb-4 bg-light">
                    <div class="py-2 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="25.134" viewBox="0 0 23.999 25.134">
                            <g id="Group_8912" data-name="Group 8912" transform="translate(-41.293 -19.076)">
                                <path id="Path_18953" data-name="Path 18953"
                                    d="M63.758,20.966V39.321c0,.054,0,.11-.008.163.01-.069.018-.135.028-.2a1.214,1.214,0,0,1-.082.3l.076-.184a1.7,1.7,0,0,1-.1.176c-.061.1.112-.122.051-.061-.023.023-.043.051-.066.074s-.041.038-.061.056c-.092.089.161-.1.048-.038-.059.033-.115.069-.176.1l.184-.076a1.184,1.184,0,0,1-.3.082l.2-.028a5.439,5.439,0,0,1-.576.008H58.56l.66,1.15a6.862,6.862,0,1,0-12.035-6.582,7.037,7.037,0,0,0-.732,2.656,6.91,6.91,0,0,0,.579,3.25,6.391,6.391,0,0,0,.339.673l.66-1.15H43.715c-.227,0-.464.015-.691-.008l.2.028a1.214,1.214,0,0,1-.3-.082l.184.076a1.7,1.7,0,0,1-.176-.1c-.1-.061.122.112.061.051-.023-.023-.051-.043-.074-.066s-.038-.041-.056-.061c-.089-.092.1.161.038.048-.033-.059-.069-.115-.1-.176l.076.184a1.214,1.214,0,0,1-.082-.3c.01.069.018.135.028.2a5.309,5.309,0,0,1-.008-.6V20.989c0-.054,0-.11.008-.163-.01.069-.018.135-.028.2a1.215,1.215,0,0,1,.082-.3l-.076.184a1.7,1.7,0,0,1,.1-.176c.061-.1-.112.122-.051.061.023-.023.043-.051.066-.074s.041-.038.061-.056c.092-.089-.161.1-.048.038.059-.033.115-.069.176-.1l-.184.076a1.184,1.184,0,0,1,.3-.082l-.2.028a6.185,6.185,0,0,1,.653-.008H63.4c.056,0,.11,0,.166.008l-.2-.028a1.215,1.215,0,0,1,.3.082l-.184-.076a1.7,1.7,0,0,1,.176.1c.1.061-.122-.112-.061-.051.023.023.051.043.074.066s.038.041.056.061c.089.092-.1-.161-.038-.048.033.059.069.115.1.176l-.076-.184a1.184,1.184,0,0,1,.082.3c-.01-.069-.018-.135-.028-.2,0,.051.005.1.008.143a.765.765,0,0,0,1.53,0A1.893,1.893,0,0,0,63.419,19.1H43.264a2.074,2.074,0,0,0-1.01.237A1.9,1.9,0,0,0,41.3,21V38.712a3.559,3.559,0,0,0,.1,1.242,1.915,1.915,0,0,0,1.216,1.175,2.017,2.017,0,0,0,.63.082h4.78a.772.772,0,0,0,.66-1.15,6.534,6.534,0,0,1-.349-.693l.076.184a6.2,6.2,0,0,1-.428-1.565c.01.069.018.135.028.2a6.223,6.223,0,0,1,0-1.629c-.01.069-.018.135-.028.2a6.2,6.2,0,0,1,.423-1.553l-.076.184a6.186,6.186,0,0,1,.413-.808c.079-.127.161-.255.25-.377l.069-.094c.01-.013.02-.025.031-.041.043-.061-.071.1-.069.089.013-.056.11-.135.148-.181a5.992,5.992,0,0,1,.63-.642c.054-.048.11-.094.166-.14l.092-.074c.087-.071-.158.117-.036.028s.245-.176.37-.257a6.1,6.1,0,0,1,.92-.484l-.184.076a6.173,6.173,0,0,1,1.553-.423l-.2.028a6.2,6.2,0,0,1,1.626,0l-.2-.028a6.2,6.2,0,0,1,1.553.423l-.184-.076a6.186,6.186,0,0,1,.808.413c.127.079.255.161.377.25l.094.069c.013.01.025.02.041.031.061.043-.1-.071-.089-.069.056.013.135.11.181.148a5.991,5.991,0,0,1,.642.63c.048.054.094.11.14.166.025.031.048.061.074.092.071.087-.117-.158-.028-.036s.176.245.257.37a6.1,6.1,0,0,1,.484.92l-.076-.184a6.173,6.173,0,0,1,.423,1.553c-.01-.069-.018-.135-.028-.2a6.335,6.335,0,0,1,0,1.629c.01-.069.018-.135.028-.2a6.171,6.171,0,0,1-.428,1.565l.076-.184a6.534,6.534,0,0,1-.349.693.771.771,0,0,0,.66,1.15h2.33c.841,0,1.68.008,2.521,0a1.891,1.891,0,0,0,1.879-1.866V20.966a.767.767,0,0,0-1.535,0Z"
                                    transform="translate(0 -0.023)" fill="#7bc4c4" />
                                <path id="Path_18954" data-name="Path 18954"
                                    d="M251.777,19.842v6.939l1.15-.66-2.506-1.313c-.107-.056-.217-.117-.326-.171a.844.844,0,0,0-.806.015c-.056.031-.115.059-.171.089-.482.252-.966.5-1.448.76l-1.18.619,1.15.66V19.842l-.765.765h5.665a.765.765,0,0,0,0-1.53h-5.665a.775.775,0,0,0-.765.765v6.939a.773.773,0,0,0,1.15.66l2.475-1.3c.12-.061.237-.125.357-.186h-.772l2.475,1.3c.12.061.237.125.357.186a.773.773,0,0,0,1.15-.66V19.842a.762.762,0,1,0-1.524,0Zm3.263,17.506a6.233,6.233,0,0,1-.054.816c.01-.069.018-.135.028-.2a6.171,6.171,0,0,1-.428,1.565l.076-.184a6.214,6.214,0,0,1-.607,1.1c-.048.071-.1.138-.15.209.148-.209.043-.056.005-.01s-.061.076-.094.112c-.12.14-.245.275-.375.4s-.268.252-.41.367l-.115.092c.2-.163.056-.043.008-.008-.069.051-.14.1-.212.148a6.1,6.1,0,0,1-1.007.546l.184-.076a6.152,6.152,0,0,1-1.563.428l.2-.028a6.262,6.262,0,0,1-1.634,0l.2.028a6.152,6.152,0,0,1-1.563-.428l.184.076a6,6,0,0,1-1.007-.546c-.071-.048-.143-.1-.212-.148-.046-.036-.191-.156.008.008l-.115-.092c-.143-.117-.278-.24-.41-.367s-.255-.263-.375-.4c-.031-.038-.064-.074-.094-.112s-.143-.2.005.01c-.048-.069-.1-.138-.15-.209a6.213,6.213,0,0,1-.607-1.1l.076.184a6.2,6.2,0,0,1-.428-1.565c.01.069.018.135.028.2a6.223,6.223,0,0,1,0-1.629c-.01.069-.018.135-.028.2a6.2,6.2,0,0,1,.423-1.553l-.076.184a6.184,6.184,0,0,1,.413-.808c.079-.127.161-.255.25-.377l.069-.094c.01-.013.02-.025.031-.041.043-.061-.071.1-.069.089.013-.056.11-.135.148-.181a5.992,5.992,0,0,1,.63-.642c.054-.048.11-.094.166-.14l.092-.074c.087-.071-.158.117-.036.028s.245-.176.37-.257a6.1,6.1,0,0,1,.92-.484l-.184.076a6.173,6.173,0,0,1,1.553-.423l-.2.028a6.2,6.2,0,0,1,1.626,0l-.2-.028a6.2,6.2,0,0,1,1.553.423l-.184-.076a6.186,6.186,0,0,1,.808.413c.127.079.255.161.377.25l.094.069c.013.01.025.02.041.031.061.043-.1-.071-.089-.069.056.013.135.11.181.148a5.993,5.993,0,0,1,.642.63c.048.054.094.11.14.166.025.031.048.061.074.092.071.087-.117-.158-.028-.036s.176.245.257.37a6.1,6.1,0,0,1,.484.92l-.076-.184a6.173,6.173,0,0,1,.423,1.553c-.01-.069-.018-.135-.028-.2.023.27.041.54.041.813a.765.765,0,1,0,1.53,0,6.848,6.848,0,0,0-3.939-6.205,6.727,6.727,0,0,0-1.853-.566,7.4,7.4,0,0,0-2.187.008,6.849,6.849,0,0,0-5.264,9.269,7.23,7.23,0,0,0,1.219,2.009,6.833,6.833,0,0,0,5.713,2.322,6.985,6.985,0,0,0,3.995-1.7,6.788,6.788,0,0,0,2.19-3.832,7.471,7.471,0,0,0,.127-1.305.765.765,0,0,0-1.53,0Z"
                                    transform="translate(-196.417)" fill="#7bc4c4" />
                                <path id="Path_18955" data-name="Path 18955"
                                    d="M359.965,640l1.706,1.706.242.242a.774.774,0,0,0,1.081,0l1.366-1.366,2.177-2.177.5-.5a.764.764,0,1,0-1.081-1.081l-1.366,1.366-2.177,2.177-.5.5h1.081l-1.706-1.706-.242-.242A.764.764,0,0,0,359.965,640Z"
                                    transform="translate(-310.336 -601.79)" fill="#7bc4c4" />
                            </g>
                        </svg>
                        <div class="flex-grow-1 fw-700 mx-4">{{ translate('Confirmed Order') }}</div>
                        <div class="fs-20 fw-600" style="color: #7BC4C4">
                            {{ \App\Models\Order::where('delivery_status', 'confirmed')->count() }}</div>
                    </div>
                </div>
                <div class="rounded-lg p-4 border mb-4 bg-light">
                    <div class="py-2 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26.182" viewBox="0 0 24 26.182">
                            <path id="Path_18963" data-name="Path 18963"
                                d="M16,0,4,5.455V20.727l12,5.455,12-5.455V5.455Zm0,2.4,8.045,3.657L16,9.712,7.952,6.055ZM6.182,19.323V7.645l8.727,3.965V23.288Zm19.636,0-8.727,3.966V11.61l8.727-3.966Z"
                                transform="translate(-4)" fill="#91a8d0" />
                        </svg>
                        <div class="flex-grow-1 fw-700 mx-4">{{ translate('Processed Order') }}</div>
                        <div class="fs-20 fw-600" style="color: #91A8D0">
                            {{ \App\Models\Order::where('delivery_status', 'processed')->count() }}</div>
                    </div>
                </div>
                <div class="rounded-lg p-4 border mb-4 bg-light">
                    <div class="py-2 d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.727" viewBox="0 0 24 20.727">
                            <path id="shipping-truck"
                                d="M25,13.409v5.455a1.091,1.091,0,0,1-1.091,1.091H22.818a3.273,3.273,0,1,1-6.545,0H9.727a3.273,3.273,0,1,1-6.545,0H2.091A1.091,1.091,0,0,1,1,18.864V5.773A3.273,3.273,0,0,1,4.273,2.5h9.818a3.273,3.273,0,0,1,3.273,3.273V7.955h2.182a3.273,3.273,0,0,1,2.618,1.309l2.618,3.491a.665.665,0,0,1,.076.153l.065.12A1.091,1.091,0,0,1,25,13.409ZM7.545,19.955a1.091,1.091,0,1,0-1.091,1.091A1.091,1.091,0,0,0,7.545,19.955ZM15.182,5.773a1.091,1.091,0,0,0-1.091-1.091H4.273A1.091,1.091,0,0,0,3.182,5.773v12h.851a3.273,3.273,0,0,1,4.844,0h6.305Zm2.182,6.545h4.364l-1.309-1.745a1.091,1.091,0,0,0-.873-.436H17.364Zm3.273,7.636a1.091,1.091,0,1,0-1.091,1.091A1.091,1.091,0,0,0,20.636,19.955ZM22.818,14.5H17.364v3.033a3.273,3.273,0,0,1,4.6.24h.851Z"
                                transform="translate(-1 -2.5)" fill="#ff6f61" />
                        </svg>
                        <div class="flex-grow-1 fw-700 mx-4">{{ translate('Order Delivered') }}</div>
                        <div class="fs-20 fw-600" style="color: #FF6F61">
                            {{ \App\Models\Order::where('delivery_status', 'delivered')->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="border rounded-lg px-4 pt-4 pb-3">
                    <div class="fs-16 fw-700 mb-2">{{ translate('Top Category') }}</div>
                    <ul class="list-group list-group-raw">
                        @foreach (\App\Models\Category::orderBy('sales_amount', 'desc')->take(6)->get()
            as $category)
                            <li class="list-group-item d-flex align-items-center px-0 py-5px mt-1">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($category->banner) }}" class="size-50px rounded lazyload"
                                    onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';">
                                <div class="minw-0 flex-grow-1 text-truncate-2 mx-3">{{ $category->getTranslation('name') }}
                                </div>
                                <div class="ml-auto mr-0 fw-600 text-danger">
                                    {{ format_price($category->sales_amount, true) }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="border rounded-lg px-4 pt-4 pb-3">
                    <div class="fs-16 fw-700 mb-2">{{ translate('Top Brands') }}</div>
                    <ul class="list-group list-group-raw">
                        @foreach (\App\Models\Brand::orderBy('sales_amount', 'desc')->take(6)->get()
            as $brand)
                            <li class="list-group-item d-flex align-items-center px-0 py-5px mt-1">
                                <span class="d-flex align-items-center size-50px">
                                    <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($brand->logo) }}" class="mw-100 mh-100 rounded lazyload"
                                        onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';">
                                </span>
                                <div class="minw-0 flex-grow-1 text-truncate-2 mx-3">{{ $brand->getTranslation('name') }}
                                </div>
                                <div class="ml-auto mr-0 fw-600 text-danger">{{ format_price($brand->sales_amount, true) }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="border rounded-lg p-4 mb-4">
                    <div class="fs-16 fw-700 mb-4">{{ translate('Sales stat') }}</div>
                    <canvas id="graph-2" class="w-100" height="300"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border rounded-lg p-4 mb-4">
                    <div class="fs-16 fw-700 mb-4">{{ translate('Sales by Category ') }}</div>
                    <canvas id="graph-3" class="w-100" height="300"></canvas>
                </div>
            </div>
        </div>

        <div>
            <div class="fs-16 fw-700 mb-3">{{ translate('Top Products') }}</div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-xl-items="6" data-lg-items="4"
                data-md-items="3" data-sm-items="2">
                @foreach (\App\Models\Product::where('published', 1)->orderBy('num_of_sale', 'desc')->limit(12)->get()
            as $key => $product)
                    <div class="carousel-box">
                        <div class="aiz-card-box border rounded mb-2 bg-white">
                            <div class="position-relative">
                                <a href="/product/{{ $product->slug }}" class="d-block" target="_blank">
                                    <img class="img-fit lazyload mx-auto h-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="{{ $product->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="p-md-3 p-2 text-left">
                                <div class="fs-15">
                                    @if (product_base_price($product) != product_discounted_base_price($product))
                                        <del
                                            class="fw-600 opacity-50 mr-1">{{ format_price(product_base_price($product)) }}</del>
                                    @endif
                                    <span
                                        class="fw-700 text-primary">{{ format_price(product_discounted_base_price($product)) }}</span>
                                </div>
                                <div class="rating rating-sm mt-1">
                                    {{ renderStarRating($product->rating) }}
                                </div>
                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                    <a href="/product/{{ $product->slug }}" class="d-block text-reset"
                                        target="_blank">{{ $product->getTranslation('name') }}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    @endcan

@endsection

@section('script')
    <script>
        let draw = Chart.controllers.line.prototype.draw;
        Chart.controllers.line = Chart.controllers.line.extend({
            draw: function() {
                draw.apply(this, arguments);
                let ctx = this.chart.chart.ctx;
                let _stroke = ctx.stroke;
                ctx.stroke = function() {
                    ctx.save();
                    ctx.shadowColor = 'rgb(0, 0, 0, .16)';
                    ctx.shadowBlur = 3;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 3;
                    _stroke.apply(this, arguments)
                    ctx.restore();
                }
            }
        });

        AIZ.plugins.chart('#graph-1', {
            type: 'line',
            data: {
                labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                datasets: [{
                    data: [
                        {{ $cached_graph_data['sales_number_per_month'][1] }},
                        {{ $cached_graph_data['sales_number_per_month'][2] }},
                        {{ $cached_graph_data['sales_number_per_month'][3] }},
                        {{ $cached_graph_data['sales_number_per_month'][4] }},
                        {{ $cached_graph_data['sales_number_per_month'][5] }},
                        {{ $cached_graph_data['sales_number_per_month'][6] }},
                        {{ $cached_graph_data['sales_number_per_month'][7] }},
                        {{ $cached_graph_data['sales_number_per_month'][8] }},
                        {{ $cached_graph_data['sales_number_per_month'][9] }},
                        {{ $cached_graph_data['sales_number_per_month'][10] }},
                        {{ $cached_graph_data['sales_number_per_month'][11] }},
                        {{ $cached_graph_data['sales_number_per_month'][12] }}
                    ],
                    fill: false,
                    borderColor: "rgb(221, 65, 36)",
                    borderWidth: 4,
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            min: 0,
                            max: 150,
                        },
                    }],
                    xAxes: [{
                        display: false,
                    }],
                    ticks: {
                        min: 0
                    },
                },
            }
        })

        AIZ.plugins.chart('#graph-2', {
            type: 'bar',
            data: {
                labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                datasets: [{
                    label: '{{ translate('Sales ($)') }}',
                    data: [
                        {{ $cached_graph_data['sales_amount_per_month'][1] }},
                        {{ $cached_graph_data['sales_amount_per_month'][2] }},
                        {{ $cached_graph_data['sales_amount_per_month'][3] }},
                        {{ $cached_graph_data['sales_amount_per_month'][4] }},
                        {{ $cached_graph_data['sales_amount_per_month'][5] }},
                        {{ $cached_graph_data['sales_amount_per_month'][6] }},
                        {{ $cached_graph_data['sales_amount_per_month'][7] }},
                        {{ $cached_graph_data['sales_amount_per_month'][8] }},
                        {{ $cached_graph_data['sales_amount_per_month'][9] }},
                        {{ $cached_graph_data['sales_amount_per_month'][10] }},
                        {{ $cached_graph_data['sales_amount_per_month'][11] }},
                        {{ $cached_graph_data['sales_amount_per_month'][12] }}
                    ],
                    backgroundColor: '#DD4124',
                    borderColor: '#DD4124',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#fff',
                            zeroLineColor: '#f2f3f8'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10,
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fff'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10
                        },
                        barThickness: 20,
                        barPercentage: .5,
                        categoryPercentage: .5,
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        AIZ.plugins.chart('#graph-3', {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($root_categories as $key => $category)
                        '{{ $category->getTranslation('name') }}',
                    @endforeach
                ],
                datasets: [{
                    label: '{{ translate('Sales ($)') }}',
                    data: [
                        {{ $cached_graph_data['sales_amount_string'] }}
                    ],
                    backgroundColor: '#91A8D0',
                    borderColor: '#91A8D0',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#fff',
                            zeroLineColor: '#f2f3f8'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10,
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fff'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10
                        },
                        barThickness: 20,
                        barPercentage: .5,
                        categoryPercentage: .5,
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
@endsection
