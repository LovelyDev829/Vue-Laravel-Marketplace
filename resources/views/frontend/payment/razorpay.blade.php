<html>
<head>
	<title>Razorpay Payment</title>
	<meta name="viewport">
	<link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
</head>
<body>

    <form action="{{ route('razorpay.payment') }}" method="POST" id='razor-pay' style="display: none;">
        <!-- Note that the amount is in paise = 50 INR -->
        <!--amount need to be in paisa-->
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ env('RAZOR_KEY') }}"
            data-amount="{{ $data['amount']}}"
            data-buttontext=""
            data-name="{{ $data['app_name'] }}"
            data-description="{{ $data['payment_title'] }}"
            data-image="{{ $data['app_logo'] }}"
            data-prefill.name="{{ $data['name'] }}"
            data-prefill.email="{{ $data['email'] }}"
            data-theme.color="#ff7529">
        </script>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
    </form>


    
	<script src="{{ static_asset('assets/js/vendors.js') }}" ></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#razor-pay').submit()
        });
    </script>
</body>
</html>
