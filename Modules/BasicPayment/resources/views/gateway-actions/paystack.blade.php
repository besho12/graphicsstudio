@php
    $method = $paymentMethod;
    $paystack_public_key = $paymentService->getGatewayDetails($method)->paystack_public_key ?? '';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paystack Checkout</title>
</head>

<body>
    @php
        $paymentUrl = route('pay-via-paystack');
        $successUrl = route('payment-success');
        $failedUrl = route('payment-failed');
    @endphp
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    {{-- paystack start --}}
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        "use strict";
        (function($) {
            $(document).ready(function() {
                payWithPaystack();
            });

        })(jQuery);

        function payWithPaystack() {
            var paymentUrl = "{!! $paymentUrl !!}";
            var handler = PaystackPop.setup({
                key: '{{ $paystack_public_key }}',
                email: '{{ $user?->email }}',
                amount: "{{ session('paid_amount') * 100 }}",
                currency: "{{ session('payable_currency') }}",
                callback: function(response) {
                    let reference = response.reference;
                    let tnx_id = response.transaction;
                    let _token = "{{ csrf_token() }}";
                    var payable_amount = "{{ session('paid_amount') }}";

                    $.ajax({
                        type: "get",
                        data: {
                            reference,
                            tnx_id,
                            _token,
                            payable_amount
                        },
                        url: paymentUrl,
                        success: function(response) {
                            window.location.href = "{{ $successUrl }}";
                        },
                        error: function(response) {
                            window.location.href = "{{ $failedUrl }}";
                        }
                    });
                },
                onClose: function() {
                    window.location.href = "{{ $failedUrl }}";
                }
            });
            handler.openIframe();
        }
    </script>
</body>

</html>
