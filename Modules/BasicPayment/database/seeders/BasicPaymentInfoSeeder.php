<?php

namespace Modules\BasicPayment\database\seeders;

use Illuminate\Database\Seeder;
use Modules\BasicPayment\app\Models\BasicPayment;
use Modules\Currency\app\Models\MultiCurrency;

class BasicPaymentInfoSeeder extends Seeder
{
    public function run(): void
    {
        $basic_payment_info = [
            'stripe_key' => 'pk_test_33mdngCLuLsmECXOe8mbde9f00pZGT4uu9',
            'stripe_secret' => 'sk_test_MroTZzRZRv2KJ9Hmaro73SE800UOR90Q9u',
            'stripe_currency_id' => MultiCurrency::first()?->id,
            'stripe_status' => 'active',
            'stripe_charge' => 0.00,
            'stripe_image' => 'uploads/website-images/stripe.png',
            'paypal_client_id' => 'AWlV5x8Lhj9BRF8-TnawXtbNs-zt69mMVXME1BGJUIoDdrAYz8QIeeTBQp0sc2nIL9E529KJZys32Ipy',
            'paypal_secret_key' => 'EEvn1J_oIC6alxb-FoF4t8buKwy4uEWHJ4_Jd_wolaSPRMzFHe6GrMrliZAtawDDuE-WKkCKpWGiz0Yn',
            'paypal_account_mode' => 'sandbox',
            'paypal_currency_id' => MultiCurrency::first()?->id,
            'paypal_charge' => 0.00,
            'paypal_status' => 'active',
            'paypal_image' => 'uploads/website-images/paypal.png',
            'bank_information' => "Bank Name => Your bank name\r\nAccount Number =>  Your bank account number\r\nRouting Number => Your bank routing number\r\nBranch => Your bank branch name",
            'bank_status' => 'active',
            'bank_image' => 'uploads/website-images/bank-pay.png',
            'bank_charge' => 0.00,
            'bank_currency_id' => MultiCurrency::first()?->id,
            'razorpay_key' => 'rzp_test_cvrsy43xvBZfDT',
            'razorpay_secret' => 'c9AmI4C5vOfSWmZehhlns5df',
            'razorpay_name' => 'WebSolutionUs',
            'razorpay_description' => 'This is test payment window',
            'razorpay_charge' => 0.00,
            'razorpay_theme_color' => '#6d0ce4',
            'razorpay_status' => 'active',
            'razorpay_currency_id' => MultiCurrency::first()?->id,
            'razorpay_image' => 'uploads/website-images/razorpay.png',
            'flutterwave_public_key' => 'FLWPUBK_TEST-5760e3ff9888aa1ab5e5cd1ec3f99cb1-X',
            'flutterwave_secret_key' => 'FLWSECK_TEST-81cb5da016d0a51f7329d4a8057e766d-X',
            'flutterwave_app_name' => 'WebSolutionUs',
            'flutterwave_charge' => 0.00,
            'flutterwave_currency_id' => MultiCurrency::first()?->id,
            'flutterwave_status' => 'active',
            'flutterwave_image' => 'uploads/website-images/flutterwave.png',
            'paystack_public_key' => 'pk_test_057dfe5dee14eaf9c3b4573df1e3760c02c06e38',
            'paystack_secret_key' => 'sk_test_77cb93329abbdc18104466e694c9f720a7d69c97',
            'paystack_status' => 'active',
            'paystack_charge' => 0.00,
            'paystack_image' => 'uploads/website-images/paystack.png',
            'paystack_currency_id' => MultiCurrency::first()?->id,
            'mollie_key' => 'test_HFc5UhscNSGD5jujawhtNFs3wM3B4n',
            'mollie_charge' => 0.00,
            'mollie_image' => 'uploads/website-images/mollie.png',
            'mollie_status' => 'active',
            'mollie_currency_id' => MultiCurrency::first()?->id,
            'instamojo_account_mode' => 'Sandbox',
            'instamojo_api_key' => 'test_ffc6f0ad486d6ae0ba9ca2f46da',
            'instamojo_auth_token' => 'test_ded356ba75e1aaa80bdd8f438d7',
            'instamojo_charge' => 0.00,
            'instamojo_image' => 'uploads/website-images/instamojo.png',
            'instamojo_currency_id' => MultiCurrency::first()?->id,
            'instamojo_status' => 'active',
            'cash_on_delivery_status' => 'active',
            'cash_on_delivery_image' => 'uploads/website-images/cash-on-delivery.png',
        ];

        foreach ($basic_payment_info as $index => $payment_item) {
            $new_item = new BasicPayment();
            $new_item->key = $index;
            $new_item->value = $payment_item;
            $new_item->save();
        }
    }
}
