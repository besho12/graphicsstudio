<script>
    var base_url = "{{ url('/') }}";
    var basic_error_message = "{{ __('Something went wrong') }}";
    var currency_code = "{{session('currency_icon','$')}}";
    var coupon_required_msg = "{{__('Coupon is required')}}";
    var sending = "{{__('Sending')}}";
</script>