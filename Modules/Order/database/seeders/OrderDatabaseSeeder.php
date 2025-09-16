<?php

namespace Modules\Order\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderAddress;
use Modules\Order\app\Models\OrderProduct;

class OrderDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user = User::first();

        $order_list = [
            [
                'user_id'             => $user->id,
                'product_qty'         => 3,
                'sub_total_usd'       => 310,
                'order_tax_usd'       => 31.0,
                'discount_usd'        => 20.0,
                'delivery_charge_usd' => 35,
                'amount_usd'          => 356.00,
                'sub_total'           => 310,
                'order_tax'           => 31.0,
                'discount'            => 20.0,
                'delivery_charge'     => 35,
                'paid_amount'         => 356.00,
                'payable_with_charge' => 356.00,
                'gateway_charge'      => 0,
                'payment_method'      => 'stripe',
                'payable_currency'    => 'USD',
                'transaction_id'      => 'txn_3PVRqSF56Pb8BOOX0JoBPtfL',
                'payment_status'      => 'success',
                'order_status'        => 'pending',
                'payment_details'     => '{"transaction_id":"txn_3PVRqSF56Pb8BOOX0JoBPtfL","amount":16284,"currency":"usd","paid":true,"description":"Cresta","seller_message":"Payment complete.","payment_method":"card_1PVRqMF56Pb8BOOXvTEhlAhB","card_last4_digit":"4242","card_brand":"visa - US","receipt_url":"https:\/\/pay.stripe.com\/receipts\/payment\/CAcaFwoVYWNjdF8xSlU2MWFGNTZQYjhCT09YKLyo6bMGMgara-EpY086LBbmENfUZ25sXxMlcpRNfNz_20CkAFVtAMathz0pv_YI3rwNZX1HWU8N50Vl","status":"succeeded"}',
                'order_products'      => [
                    [
                        'product_id'     => 3,
                        'product_name'   => 'Watch',
                        'unit_price_usd' => 35,
                        'total_usd'      => 70,
                        'unit_price'     => 35,
                        'total'          => 70,
                        'qty'            => 2,
                    ],
                    [
                        'product_id'     => 20,
                        'product_name'   => 'Iphone',
                        'unit_price_usd' => 240,
                        'total_usd'      => 240,
                        'unit_price'     => 240,
                        'total'          => 240,
                        'qty'            => 1,
                    ],
                ],
            ],
            [
                'user_id'             => $user->id,
                'product_qty'         => 1,
                'sub_total_usd'       => 48,
                'order_tax_usd'       => 0,
                'discount_usd'        => 0,
                'delivery_charge_usd' => 50,
                'amount_usd'          => 98,
                'sub_total'           => 48,
                'order_tax'           => 0,
                'discount'            => 0,
                'delivery_charge'     => 50,
                'paid_amount'         => 98,
                'payable_with_charge' => 98,
                'gateway_charge'      => 0,
                'payment_method'      => 'hand_cash',
                'payable_currency'    => 'USD',
                'transaction_id'      => 'hand_cash',
                'payment_status'      => 'pending',
                'order_status'        => 'pending',
                'created_at'          => '2024-06-24 04:36:09',
                'updated_at'          => '2024-06-24 04:36:09',
                'payment_details'     => null,
                'order_products'      => [
                    [
                        'order_id'       => 4,
                        'product_id'     => 4,
                        'product_name'   => 'Winter Jacket',
                        'unit_price_usd' => 48,
                        'total_usd'      => 48,
                        'unit_price'     => 48,
                        'total'          => 48,
                        'qty'            => 1,
                    ],
                ],
            ],
            [
                'user_id'             => $user->id,
                'product_qty'         => 2,
                'sub_total_usd'       => 718,
                'order_tax_usd'       => 71.8,
                'discount_usd'        => 99.00,
                'delivery_charge_usd' => 40,
                'amount_usd'          => 730.08,
                'sub_total'           => 718,
                'order_tax'           => 71.8,
                'discount'            => 99.00,
                'delivery_charge'     => 40,
                'paid_amount'         => 730.08,
                'payable_with_charge' => 730.08,
                'gateway_charge'      => 0,
                'payment_method'      => 'paypal',
                'payable_currency'    => 'USD',
                'transaction_id'      => 'HUR3FNQ2XCB2U',
                'payment_status'      => 'success',
                'order_status'        => 'pending',
                'payment_details'     => '{"payments_captures_id":"81D80058RX438825R","amount":"871.01","currency":"USD","paid":"871.01","paypal_fee":"30.89","net_amount":"840.12","status":"COMPLETED"}',
                'order_products'      => [
                    [
                        'product_id'     => 21,
                        'product_name'   => 'Gaming Laptop',
                        'unit_price_usd' => 699,
                        'total_usd'      => 699,
                        'unit_price'     => 699,
                        'total'          => 699,
                        'qty'            => 1,
                        'created_at'     => '2024-06-24 05:44:50',
                        'updated_at'     => '2024-06-24 05:44:50',
                    ],
                    [
                        'product_id'     => 18,
                        'product_name'   => 'UltraSlim Power Bank',
                        'unit_price_usd' => 19,
                        'total_usd'      => 19,
                        'unit_price'     => 19,
                        'total'          => 19,
                        'qty'            => 1,
                    ],
                ],
            ],
            [
                'user_id'             => $user->id,
                'product_qty'         => 2,
                'sub_total_usd'       => 88,
                'order_tax_usd'       => 8.0,
                'discount_usd'        => 0.0,
                'delivery_charge_usd' => 0,
                'amount_usd'          => 96.00,
                'sub_total'           => 88,
                'order_tax'           => 8.0,
                'discount'            => 0.0,
                'delivery_charge'     => 0,
                'paid_amount'         => 96.00,
                'payable_with_charge' => 96.00,
                'gateway_charge'      => 0,
                'payment_method'      => 'stripe',
                'payable_currency'    => 'USD',
                'transaction_id'      => 'txn_3PVRqSF56Pb8KEDJYUSDPtfL',
                'payment_status'      => 'success',
                'order_status'        => 'pending',
                'payment_details'     => '{"transaction_id":"txn_3PVRqSF56Pb8KEDJYUSDPtfL","amount":16284,"currency":"usd","paid":true,"description":"Frisk","seller_message":"Payment complete.","payment_method":"card_1PVRqMF56Pb8BOOXvTEhlAhB","card_last4_digit":"4242","card_brand":"visa - US","receipt_url":"https:\/\/pay.stripe.com\/receipts\/payment\/CAcaFwoVYWNjdF8xSlU2MWFGNTZQYjhCT09YKLyo6bMGMgara-EpY086LBbmENfUZ25sXxMlcpRNfNz_20CkAFVtAMathz0pv_YI3rwNZX1HWU8N50Vl","status":"succeeded"}',
                'order_products'      => [
                    [
                        'product_id'     => 15,
                        'product_name'   => 'Aabcserv',
                        'unit_price_usd' => 29,
                        'total_usd'      => 29,
                        'unit_price'     => 29,
                        'total'          => 29,
                        'qty'            => 1,
                    ],
                    [
                        'product_id'     => 16,
                        'product_name'   => 'FindEstate',
                        'unit_price_usd' => 59,
                        'total_usd'      => 59,
                        'unit_price'     => 59,
                        'total'          => 59,
                        'qty'            => 1,
                    ],
                ],
            ],
        ];

        foreach ($order_list as $order_data) {
            $order = new Order();
            $order->user_id = $order_data['user_id'];
            $order->order_id = substr(rand(0, time()), 0, 10);
            $order->product_qty = $order_data['product_qty'];
            $order->sub_total_usd = $order_data['sub_total_usd'];
            $order->order_tax_usd = $order_data['order_tax_usd'];
            $order->discount_usd = $order_data['discount_usd'];
            $order->delivery_charge_usd = $order_data['delivery_charge_usd'];
            $order->amount_usd = $order_data['amount_usd'];

            $order->sub_total = $order_data['sub_total'];
            $order->order_tax = $order_data['order_tax'];
            $order->discount = $order_data['discount'];
            $order->delivery_charge = $order_data['delivery_charge'];
            $order->paid_amount = $order_data['paid_amount'];
            $order->gateway_charge = $order_data['gateway_charge'];
            $order->payable_with_charge = $order_data['payable_with_charge'];
            $order->payment_method = $order_data['payment_method'];
            $order->payable_currency = $order_data['payable_currency'];
            $order->transaction_id = $order_data['transaction_id'];
            $order->payment_status = $order_data['payment_status'];
            $order->order_status = $order_data['order_status'];
            $order->payment_details = $order_data['payment_details'];
            $order->save();

            foreach ($order_data['order_products'] as $order_product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $order_product['product_id'];
                $orderProduct->product_name = $order_product['product_name'];
                $orderProduct->unit_price = $order_product['unit_price'];
                $orderProduct->qty = $order_product['qty'];
                $orderProduct->total = $order_product['total'];
                $orderProduct->unit_price_usd = $order_product['unit_price_usd'];
                $orderProduct->total_usd = $order_product['total_usd'];
                $orderProduct->save();
            }

            $orderAddress = new OrderAddress();
            $orderAddress->order_id = $order->id;
            $orderAddress->billing_first_name = "Curtis Campher";
            $orderAddress->billing_last_name = null;
            $orderAddress->billing_email = "user@gmail.com";
            $orderAddress->billing_phone = "2420 -136- 1452";
            $orderAddress->billing_address = "4A, Park Street";
            $orderAddress->billing_country = "United States";
            $orderAddress->billing_state = "Florida";
            $orderAddress->billing_city = "Washington DC";
            $orderAddress->billing_zip_code = "8834";

            $orderAddress->shipping_first_name = "Curtis Campher";
            $orderAddress->shipping_last_name = null;
            $orderAddress->shipping_email = "user@gmail.com";
            $orderAddress->shipping_phone = "2420 -136- 1452";
            $orderAddress->shipping_address = "4A, Park Street";
            $orderAddress->shipping_country = "United States";
            $orderAddress->shipping_state = "Florida";
            $orderAddress->shipping_city = "Washington DC";
            $orderAddress->shipping_zip_code = "8834";
            $orderAddress->save();

        }
    }
}
