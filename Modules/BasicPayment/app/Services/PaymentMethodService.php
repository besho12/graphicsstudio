<?php

namespace Modules\BasicPayment\app\Services;

use App\Traits\GetGlobalInformationTrait;
use Modules\BasicPayment\app\Enums\BasicPaymentSupportedCurrencyListEnum;
use Modules\BasicPayment\app\Interfaces\PaymentMethodInterface;
use Modules\Currency\app\Models\MultiCurrency;

class PaymentMethodService implements PaymentMethodInterface {
    use GetGlobalInformationTrait;

    const STRIPE = 'stripe';

    const PAYPAL = 'paypal';

    const BANK_PAYMENT = 'bank';
    const HAND_CASH = 'hand_cash';

    // Holds the supported payment gateways
    protected static array $supportedPayments = [
        self::STRIPE,
        self::PAYPAL,
        self::BANK_PAYMENT,
        self::HAND_CASH,
    ];

    /**
     * @param array $additionalPayments
     */
    public static function extendSupportedPayments(array $additionalPayments): void {
        static::$supportedPayments = array_unique(
            array_merge(static::$supportedPayments, $additionalPayments)
        );
    }

    // Holds the gateways that supports multi currency
    protected static array $multiCurrencySupported = [
        self::STRIPE,
        self::PAYPAL,
        self::BANK_PAYMENT,
        self::HAND_CASH,
    ];

    /**
     * @param array $additionalGateways
     */
    public static function extendMultiCurrencySupported(array $additionalGateways): void {
        static::$multiCurrencySupported = array_unique(
            array_merge(static::$multiCurrencySupported, $additionalGateways)
        );
    }

    /**
     * Undocumented function
     */
    public function getSupportedPayments(): array {
        return self::$supportedPayments;
    }

    /**
     * Get the value of the current gateway's constant.
     */
    public function getValue($currentGateway): ?string {
        return in_array($currentGateway, self::$supportedPayments, true)
        ? $currentGateway
        : null;
    }

    /**
     * Undocumented function
     */
    public function isSupportedGateway(string $gatewayName): bool {
        return in_array(strtolower($gatewayName), self::$supportedPayments, true);
    }

    /**
     * Undocumented function
     */
    public function isSupportsMultiCurrency(string $gatewayName): bool {
        return in_array(strtolower($gatewayName), self::$multiCurrencySupported, true);
    }

    /**
     * Undocumented function
     */
    public function getPaymentName(string $gatewayName): ?string {
        return match ($gatewayName) {
            self::STRIPE => 'Stripe',
            self::PAYPAL => 'PayPal',
            self::BANK_PAYMENT => 'Bank Payment',
            self::HAND_CASH => 'Hand Cash',
            default => null,
        };
    }

    /**
     * Undocumented function
     */
    public function getGatewayDetails(string $gatewayName): ?object {
        $basicPayment = $this->get_basic_payment_info();

        return match ($gatewayName) {
            self::STRIPE => (object) [
                'stripe_key'    => $basicPayment->stripe_key ?? null,
                'stripe_secret' => $basicPayment->stripe_secret ?? null,
                'currency_id'   => $basicPayment->stripe_currency_id ?? null,
                'stripe_status' => $basicPayment->stripe_status ?? null,
                'charge'        => $basicPayment->stripe_charge ?? null,
                'stripe_image'  => $basicPayment->stripe_image ?? null,
            ],
            self::PAYPAL => (object) [
                'paypal_client_id'    => $basicPayment->paypal_client_id ?? null,
                'paypal_secret_key'   => $basicPayment->paypal_secret_key ?? null,
                'paypal_account_mode' => $basicPayment->paypal_account_mode ?? null,
                'currency_id'         => $basicPayment->paypal_currency_id ?? null,
                'charge'              => $basicPayment->paypal_charge ?? null,
                'paypal_status'       => $basicPayment->paypal_status ?? null,
                'paypal_image'        => $basicPayment->paypal_image ?? null,
            ],
            self::BANK_PAYMENT => (object) [
                'bank_information' => $basicPayment->bank_information ?? null,
                'bank_status'      => $basicPayment->bank_status ?? null,
                'bank_image'       => $basicPayment->bank_image ?? null,
                'charge'           => $basicPayment->bank_charge ?? null,
                'currency_id'      => $basicPayment->bank_currency_id ?? null,
            ],
            self::HAND_CASH => (object) [
                'hand_cash_information' => $basicPayment->hand_cash_information ?? null,
                'cash_on_delivery_image'       => $basicPayment->cash_on_delivery_image ?? null,
                'charge'                => $basicPayment->hand_cash_charge ?? null,
                'cash_on_delivery_status'      => $basicPayment->cash_on_delivery_status ?? null,
            ],
            default => (object) false,
        };
    }

    /**
     * Undocumented function
     */
    public function isActive(string $gatewayName): bool {
        $gatewayDetails = $this->getGatewayDetails($gatewayName);
        $activeStatus = config('basicpayment.default_status.active_text');

        return match ($gatewayName) {
            self::STRIPE => $gatewayDetails->stripe_status == $activeStatus,
            self::PAYPAL => $gatewayDetails->paypal_status == $activeStatus,
            self::BANK_PAYMENT => $gatewayDetails->bank_status == $activeStatus,
            self::HAND_CASH => $gatewayDetails->cash_on_delivery_status == $activeStatus,
            default => false,
        };
    }

    /**
     * Undocumented function
     */
    public function getIcon(string $gatewayName): string {
        return match ($gatewayName) {
            self::STRIPE => 'fa-cc-stripe',
            self::PAYPAL => 'fa-cc-paypal',
            self::BANK_PAYMENT => 'fa-credit-card',
            self::HAND_CASH => 'fa-money-bill-alt',
            default => null,
        };
    }

    /**
     * Undocumented function
     *
     * @param [type] $gatewayName
     */
    public function getLogo($gatewayName): ?string {
        $basicPayment = $this->get_basic_payment_info();

        return match ($gatewayName) {
            self::STRIPE => $basicPayment->stripe_image ? asset($basicPayment->stripe_image) : asset('uploads/website-images/stripe.png'),
            self::PAYPAL => $basicPayment->paypal_image ? asset($basicPayment->paypal_image) : asset('uploads/website-images/paypal.png'),
            self::BANK_PAYMENT => $basicPayment->bank_image ? asset($basicPayment->bank_image) : asset('uploads/website-images/bank-pay.png'),
            self::HAND_CASH => $basicPayment->cash_on_delivery_image ? asset($basicPayment->cash_on_delivery_image) : asset('uploads/website-images/cash-on-delivery.png'),
            default => null,
        };
    }

    protected static array $additionalActiveGateways = [];
    /**
     * Add additional active gateways to the list.
     *
     * @param array $additionalActiveGatewaysList
     */
    public static function additionalActiveGatewaysList(array $additionalActiveGatewaysList): void {
        static::$additionalActiveGateways = array_merge(static::$additionalActiveGateways, $additionalActiveGatewaysList);
    }
    public function getActiveGatewaysWithDetails(): array {
        $basicPayment = $this->get_basic_payment_info();
        $activeStatus = config('basicpayment.default_status.active_text');

        // Base gateways
        $gateways = [
            self::STRIPE       => [
                'name'   => 'Stripe',
                'logo'   => asset($basicPayment->stripe_image ?? 'uploads/website-images/stripe.png'),
                'status' => $basicPayment->stripe_status == $activeStatus,
            ],
            self::PAYPAL       => [
                'name'   => 'PayPal',
                'logo'   => asset($basicPayment->paypal_image ?? 'uploads/website-images/paypal.png'),
                'status' => $basicPayment->paypal_status == $activeStatus,
            ],
            self::BANK_PAYMENT => [
                'name'   => 'Bank Payment',
                'logo'   => asset($basicPayment->bank_image ?? 'uploads/website-images/bank-pay.png'),
                'status' => $basicPayment->bank_status == $activeStatus,
            ],
            self::HAND_CASH => [
                'name' => 'Hand Cash',
                'logo' => asset($basicPayment->cash_on_delivery_image ?? 'uploads/website-images/cash-on-delivery.png'),
                'status' => $basicPayment->cash_on_delivery_status == $activeStatus,
            ],
        ];

        // Merge base gateways with additional gateways
        $allGateways = array_merge($gateways, static::$additionalActiveGateways);

        // Filter only active gateways
        return array_filter($allGateways, fn($gateway) => $gateway['status'] === true);
    }

    /**
     * Undocumented function
     *
     * @param [type] $gatewayName
     * @param [type] $code
     */
    public function isCurrencySupported($gatewayName, $code = null): bool {
        if (is_null($code)) {
            $code = getSessionCurrency();
        }

        return match ($gatewayName) {
            self::STRIPE => BasicPaymentSupportedCurrencyListEnum::isStripeSupportedCurrencies($code),
            self::PAYPAL => BasicPaymentSupportedCurrencyListEnum::isPaypalSupportedCurrencies($code),
            self::BANK_PAYMENT => str($code)->lower() == str(MultiCurrency::where('is_default', 'yes')->first()->currency_code)->lower(),
            self::HAND_CASH => true,
            default => false,
        };
    }

    /**
     * Undocumented function
     *
     * @param [type] $gatewayName
     */
    public function getSupportedCurrencies($gatewayName): array {
        return match ($gatewayName) {
            self::STRIPE => BasicPaymentSupportedCurrencyListEnum::getStripeSupportedCurrencies(),
            self::PAYPAL => BasicPaymentSupportedCurrencyListEnum::getPaypalSupportedCurrencies(),
            self::BANK_PAYMENT => MultiCurrency::where('is_default', 'yes')->pluck('currency_code')->toArray(),
            self::HAND_CASH => MultiCurrency::where('is_default', 'yes')->pluck('currency_code')->toArray(),
            default => [],
        };
    }

    /**
     * @param string $gatewayName
     */
    public function getBladeView(string $gatewayName): ?string {
        return match ($gatewayName) {
            self::STRIPE => 'basicpayment::gateway-actions.stripe',
            self::PAYPAL => 'basicpayment::gateway-actions.paypal',
            self::BANK_PAYMENT => 'basicpayment::gateway-actions.bank',
            self::HAND_CASH => 'basicpayment::gateway-actions.hand-cash',
            default => null,
        };
    }

    /**
     * Undocumented function
     *
     * @param [type] $gatewayName
     * @param [type] $amount
     * @param $currency_code
     */
    public function getPayableAmount($gatewayName, $amount,$currency_code = null): object {
        return $this->calculate_payable_charge($amount, $gatewayName,$currency_code);
    }
    /**
     * Undocumented function
     *
     * @param [type] $gatewayName
     * @param [type] $amount
     * @param $currency_code
     */
    public function getApiPayableAmount($gatewayName, $amount,$currency_code): object {
        return $this->calculate_api_payable_charge($amount, $gatewayName,$currency_code);
    }

    /**
     * Undocumented function
     */
    public static function removeSessions(): void {
        session()->forget(
            [
                'payable_amount',
                'gateway_charge',
                'currency_rate',
                'after_success_gateway',
                'payable_with_charge',
                'after_success_url',
                'after_failed_url',
                'order',
                'payable_currency',
                'delivery_charge',
                'paid_amount',
                'after_success_transaction',
                'payment_details',
                'shipping_method_id',
            ]);
    }
}
