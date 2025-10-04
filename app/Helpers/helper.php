<?php

use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Modules\Order\app\Models\Order;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Modules\Language\app\Models\Language;
use Modules\Marquee\app\Models\NewsTicker;
use Modules\Order\app\Models\ShippingMethod;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\SocialLink\app\Models\SocialLink;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\GlobalSetting\app\Models\CustomCode;
use Modules\BasicPayment\app\Models\BasicPayment;
use App\Exceptions\AccessPermissionDeniedException;
use Modules\PageBuilder\app\Models\CustomizeablePage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

function file_upload(UploadedFile $file, string $path = 'uploads/custom-images/', string | null $oldFile = '', bool $optimize = false) {
    $extention = $file->getClientOriginalExtension();
    $file_name = 'wsus-img' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
    $file_name = $path . $file_name;
    $file->move(public_path($path), $file_name);

    try {
        if ($oldFile && !str($oldFile)->contains('uploads/website-images') && File::exists(public_path($oldFile))) {
            unlink(public_path($oldFile));
        }

        if ($optimize) {
            ImageOptimizer::optimize(public_path($file_name));
        }
    } catch (Exception $e) {
        Log::info($e->getMessage());
    }

    return $file_name;
}
// file upload method
if (!function_exists('allLanguages')) {
    function allLanguages() {
        $allLanguages = Cache::rememberForever('allLanguages', function () {
            return Language::select('code', 'name', 'direction', 'is_default', 'status')->get();
        });

        if (!$allLanguages) {
            $allLanguages = Language::select('code', 'name', 'direction','is_default', 'status')->get();
        }

        return $allLanguages;
    }
}

if (!function_exists('getSessionLanguage')) {
    function getSessionLanguage(): string {
        if (!session()->has('lang')) {
            $language = allLanguages()->where('is_default',true)->first();
            session()->put('lang', $language?->code ?? config('app.locale'));
            session()->forget('text_direction');
            session()->put('text_direction', $language?->direction ?? 'ltr');
        }

        $lang = Session::get('lang');

        return $lang;
    }
}
if (!function_exists('setLanguage')) {
    function setLanguage($code) {
        $lang = Language::whereCode($code)->first();

        if (session()->has('lang')) {
            sessionForgetLangChang();
        }
        if ($lang) {
            session()->put('lang', $lang->code);
            session()->put('text_direction', $lang->direction);
            return true;
        }
        session()->put('lang', config('app.locale'));
        return false;
    }
}
if (!function_exists('sessionForgetLangChang')) {
    function sessionForgetLangChang() {
        session()->forget('lang');
        session()->forget('text_direction');
    }
}

if (!function_exists('allCurrencies')) {
    function allCurrencies() {
        $allCurrencies = Cache::rememberForever('allCurrencies', function () {
            return MultiCurrency::all();
        });

        if (!$allCurrencies) {
            $allCurrencies = MultiCurrency::all();
        }

        return $allCurrencies;
    }
}

if (!function_exists('getSessionCurrency')) {
    function getSessionCurrency(): string {
        if (!session()->has('currency_code') || !session()->has('currency_rate') || !session()->has('currency_position')) {
            $currency = allCurrencies()->where('is_default', 'yes')->first();
            session()->put('currency_code', $currency->currency_code);
            session()->forget('currency_position');
            session()->put('currency_position', $currency->currency_position);
            session()->forget('currency_icon');
            session()->put('currency_icon', $currency->currency_icon);
            session()->forget('currency_rate');
            session()->put('currency_rate', $currency->currency_rate);
        }

        return Session::get('currency_code');
    }
}

function admin_lang() {
    return Session::get('admin_lang');
}

// calculate currency
if (!function_exists('currency')) {
    function currency($price, $currency_symbol = true, $decimal = true) {
        getSessionCurrency();
        $currency_icon = Session::get('currency_icon');
        $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;
        $currency_position = Session::get('currency_position');

        $price = $price * $currency_rate;

        if ($decimal) {
            $price = number_format($price, 2, '.', ',');
        }

        if ($currency_symbol) {
            switch ($currency_position) {
            case 'before_price':
                $price = $currency_icon . $price;
                break;
            case 'before_price_with_space':
                $price = $currency_icon . ' ' . $price;
                break;
            case 'after_price':
                $price = $price . $currency_icon;
                break;
            case 'after_price_with_space':
                $price = $price . ' ' . $currency_icon;
                break;
            default:
                $price = $currency_icon . $price;
                break;
            }
        }
        return $price;
    }
}
// calculate currency
if (!function_exists('reverseCurrency')) {
    function reverseCurrency($price) {
        getSessionCurrency();
        $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;

        if ($currency_rate != 0) {
            $price = $price / $currency_rate;
        }
        return $price;

    }
}

// calculate currency
if (!function_exists('specific_currency_with_icon')) {
    function specific_currency_with_icon($currency_code, $price) {
        return "{$price} ({$currency_code})";
    }
}

// custom decode and encode input value
function html_decode($text) {
    $after_decode = htmlspecialchars_decode($text, ENT_QUOTES);

    return $after_decode;
}
if (!function_exists('currectUrlWithQuery')) {
    function currectUrlWithQuery($code) {
        $currentUrlWithQuery = request()->fullUrl();

        // Parse the query string
        $parsedQuery = parse_url($currentUrlWithQuery, PHP_URL_QUERY);

        // Check if the 'code' parameter already exists
        $codeExists = false;
        if ($parsedQuery) {
            parse_str($parsedQuery, $queryArray);
            $codeExists = isset($queryArray['code']);
        }

        if ($codeExists) {
            $updatedUrlWithQuery = preg_replace('/(\?|&)code=[^&]*/', '$1code=' . $code, $currentUrlWithQuery);
        } else {
            $updatedUrlWithQuery = $currentUrlWithQuery . ($parsedQuery ? '&' : '?') . http_build_query(['code' => $code]);
        }
        return $updatedUrlWithQuery;
    }
}

if (!function_exists('checkAdminHasPermission')) {
    function checkAdminHasPermission($permission): bool {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        return $admin->can($permission) ? true : false;
    }
}

if (!function_exists('checkAdminHasPermissionAndThrowException')) {
    function checkAdminHasPermissionAndThrowException($permission) {
        if (!checkAdminHasPermission($permission)) {
            throw new AccessPermissionDeniedException();
        }
    }
}

if (!function_exists('getSettingStatus')) {
    function getSettingStatus($key) {
        if (Cache::has('setting')) {
            $setting = Cache::get('setting');
            if (!is_null($key)) {
                return $setting->$key == 'active' ? true : false;
            }
        } else {
            try {
                return Setting::where('key', $key)->first()?->value == 'active' ? true : false;
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return false;
            }
        }

        return false;
    }
}
if (!function_exists('checkCrentials')) {
    function checkCrentials() {
        $checkCrentials = [];
        if (Cache::has('setting') && $settings = Cache::get('setting')) {

            if ($settings->mail_host == 'mail_host' || $settings->mail_username == 'mail_username' || $settings->mail_password == 'mail_password' || $settings->mail_host == '' || $settings->mail_port == '' || $settings->mail_username == '' || $settings->mail_password == '') {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Mail credentials not found'),
                    'description' => __('This may create a problem while sending email. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.email-configuration',
                ];
            }

            if ($settings->recaptcha_status !== 'inactive' && ($settings->recaptcha_site_key == 'recaptcha_site_key' || $settings->recaptcha_secret_key == 'recaptcha_secret_key' || $settings->recaptcha_site_key == '' || $settings->recaptcha_secret_key == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Google Recaptcha credentials not found'),
                    'description' => __('This may create a problem while submitting any form submission from website. Please fill up the credential from google account.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
            if ($settings->googel_tag_status !== 'inactive' && ($settings->googel_tag_id == 'googel_tag_id' || $settings->googel_tag_id == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Google Tag credentials not found'),
                    'description' => __('This may create a problem with analyzing your website through Google Tag Manager. Please fill in the credentials to avoid any issues.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->pixel_status !== 'inactive' && ($settings->pixel_app_id == 'pixel_app_id' || $settings->pixel_app_id == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Facebook Pixel credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_login_status !== 'inactive' && ($settings->gmail_client_id == 'google_client_id' || $settings->gmail_secret_id == 'google_secret_id' || $settings->gmail_client_id == '' || $settings->gmail_secret_id == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Google login credentials not found'),
                    'description' => __('This may create a problem while logging in using google. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_analytic_status !== 'inactive' && ($settings->google_analytic_id == 'google_analytic_id' || $settings->google_analytic_id == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Google Analytic credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->tawk_status !== 'inactive' && ($settings->tawk_chat_link == 'tawk_chat_link' || $settings->tawk_chat_link == '')) {
                $checkCrentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Tawk Chat Link credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
        }

        if (!Cache::has('basic_payment') && Module::isEnabled('BasicPayment')) {
            Cache::rememberForever('basic_payment', function () {
                $payment_info = BasicPayment::get();
                $basic_payment = [];
                foreach ($payment_info as $payment_item) {
                    $basic_payment[$payment_item->key] = $payment_item->value;
                }

                return (object) $basic_payment;
            });
        }

        if (Cache::has('basic_payment') && $basicPayment = Cache::get('basic_payment')) {
            if ($basicPayment->stripe_status !== 'inactive' && ($basicPayment->stripe_secret == 'stripe_secret' || $basicPayment->stripe_secret == '')) {

                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Stripe credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->paypal_status !== 'inactive' && ($basicPayment->paypal_client_id == 'paypal_client_id' || $basicPayment->paypal_secret_key == 'paypal_secret_key' || $basicPayment->paypal_client_id == '' || $basicPayment->paypal_secret_key == '')) {
                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Paypal credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->razorpay_status !== 'inactive' && ($basicPayment->razorpay_key == 'razorpay_key' || $basicPayment->razorpay_secret == 'razorpay_secret' || $basicPayment->razorpay_key == '' || $basicPayment->razorpay_secret == '')) {
                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Razorpay credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->flutterwave_status !== 'inactive' && ($basicPayment->flutterwave_public_key == 'flutterwave_public_key' || $basicPayment->flutterwave_secret_key == 'flutterwave_secret_key' || $basicPayment->flutterwave_public_key == '' || $basicPayment->flutterwave_secret_key == '')) {
                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Flutterwave credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->paystack_status !== 'inactive' && ($basicPayment->paystack_public_key == 'paystack_public_key' || $basicPayment->paystack_secret_key == 'paystack_secret_key' || $basicPayment->paystack_public_key == '' || $basicPayment->paystack_secret_key == '')) {
                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Paystack credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->mollie_status !== 'inactive' && ($basicPayment->mollie_key == 'mollie_key' || $basicPayment->mollie_key == '')) {
                $checkCredentials[] = (object) [
                    'status'      => true,
                    'message'     => __('Mollie credentials not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }
        }

        return (object) $checkCrentials;
    }
}

if (!function_exists('isRoute')) {
    function isRoute(string | array $route, ?string $returnValue = null) {
        if (is_array($route)) {
            foreach ($route as $value) {
                if (Route::is($value)) {
                    return is_null($returnValue) ? true : $returnValue;
                }
            }
            return false;
        }

        if (Route::is($route)) {
            return is_null($returnValue) ? true : $returnValue;
        }

        return false;
    }
}
if (!function_exists('customCode')) {
    function customCode() {
        return Cache::rememberForever('customCode', function () {
            return CustomCode::select('css', 'header_javascript', 'body_javascript', 'footer_javascript')->first();
        });
    }
}
if (!function_exists('customPages')) {
    function customPages() {
        return CustomizeablePage::with('translation')->whereNotIn('slug', ['privacy-policy', 'terms-conditions'])->where('status', 1)->get();
    }
}
if (!function_exists('marquees')) {
    function marquees() {
        return NewsTicker::select('id')->with([
            'translation' => function ($query) {
                $query->select('news_ticker_id', 'title');
            },
        ])->active()->latest()->get();
    }
}
if (!function_exists('socialLinks')) {
    function socialLinks() {
        return Cache::rememberForever('socialLinks', function () {
            return SocialLink::select('icon', 'link')->get();
        });
    }
}
if (!function_exists('processText')) {
    function processText($text) {
        // Replace text within curly brackets with a <span> tag
        $patternCurlyBrackets = '/\{(.*?)\}/';
        $replacementCurlyBrackets = '<b>$1</b>';
        $text = preg_replace($patternCurlyBrackets, $replacementCurlyBrackets, $text);

        // Replace backslashes with <br> tags
        $patternBackslash = '/\\\\/';
        $replacementBackslash = '<br>';
        $text = preg_replace($patternBackslash, $replacementBackslash, $text);

        // Return the modified text
        return $text;
    }
}
if (!function_exists('userAuth')) {
    function userAuth() {
        return Auth::guard('web')->user();
    }
}

if (!function_exists('deleteUnusedUploadedImages')) {
    function deleteUnusedUploadedImages($html, $uploadPath = TINYMNCE_UPLOAD_PATH) {
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $html, $matches);
        foreach (array_filter(array_map(function ($src) use ($uploadPath) {
            $path = preg_replace('/^.*\/(uploads\/.*)$/', '$1', $src);
            return preg_match("/^uploads\/{$uploadPath}\/[^\/]+\.[a-zA-Z]{3,4}$/", $path) ? $path : null;
        }, $matches[1])) as $image) {
            $fullPath = public_path($image);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
if (!function_exists('replaceImageSources')) {
    function replaceImageSources($html, $uploadPath = TINYMNCE_UPLOAD_PATH) {
        $baseUrl = url("uploads/{$uploadPath}/");
        $pattern = '/<img\s+[^>]*src=["\']([^"\']+)["\'][^>]*>/i';

        $replacement = function ($matches) use ($baseUrl) {
            $existingSrc = $matches[1];
            $newSrc = $baseUrl . '/' . basename($existingSrc);
            return str_replace($existingSrc, $newSrc, $matches[0]);
        };
        $newHtml = preg_replace_callback($pattern, $replacement, $html);
        return $newHtml;
    }
}
// Calculate total with discount
if (!function_exists('totalAmount')) {
    function totalAmount($totalAmount = null): object {
        if (is_null($totalAmount)) {
            $totalAmount = Cart::subtotal(2, '.', '');
        }
        $discount = 0.00;
        $discountedTotal = $totalAmount;
        $tax = taxCalculate($totalAmount);
        $grandTotal = $totalAmount + $tax;

        if (session()->has('discount') && session()->has('discount_type')) {
            $discount = session()->get('discount');
            $discount_type = session()->get('discount_type');

            if ($discount_type === 'percentage') {
                $discount = $totalAmount * ($discount / 100);
            }

            $discountedTotal = $totalAmount - $discount;

            $tax = taxCalculate($discountedTotal);
            $grandTotal = $discountedTotal + $tax;
        }

        return (object) ['discount' => $discount, 'discountTotal' => $discountedTotal, 'tax' => $tax, 'total' => $grandTotal];
    }
}

// Calculate total with discount
if (!function_exists('taxCalculate')) {
    function taxCalculate($totalAmount) {
        $taxPercentage = cache()->get('setting')?->tax_rate ?? 0;

        return ($totalAmount * $taxPercentage) / 100;
    }
}
// shipping method
if (!function_exists('defaultShippingMethod')) {
    function defaultShippingMethod($total,$applyDeliveryCharge  = true) {
        $setting = Cache::get('setting');

        if (!$applyDeliveryCharge || !$setting?->is_delivery_charge) {
            Session::put('shipping_method_id', 0);
            Session::put('delivery_charge', 0);
            return;
        }

        if (!Session::get('shipping_method_id') && !Session::get('delivery_charge') && $setting?->is_delivery_charge) {
            $shipping_default_method = ShippingMethod::select('id', 'fee', 'is_free', 'minimum_order')
                ->with(['translation' => function ($query) {
                    $query->select('shipping_method_id', 'title');
                }])
                ->where('is_default', 1)->where('minimum_order', '<=', $total)
                ->active()
                ->first();

            if ($shipping_default_method) {
                Session::put('shipping_method_id', $shipping_default_method->id);
                Session::put('delivery_charge', $shipping_default_method->fee);
            } else {
                Session::put('shipping_method_id', 0);
                Session::put('delivery_charge', 0);
            }
        }
    }
}
if (!function_exists('sessionLogoutAllDevice')) {
    /**
     * Logs out the specified user from all devices by clearing their session data.
     *
     * @param int $id The ID of the user to log out from all devices.
     * @param string $guard  The guard to use for logging out (default is 'web').
     *
     * @return void
     */
    function sessionLogoutAllDevice($id, $guard = 'web'): void {
        $sessionPath = storage_path('framework/sessions');
        $files = File::files($sessionPath);

        foreach ($files as $file) {
            $contents = File::get($file);
            $pattern = '/s:\d+:"login_' . $guard . '_(\w+)";i:' . $id . ';/';
            if (preg_match($pattern, $contents, $matches)) {
                auth()->guard($guard)->logout();

                $updatedContents = preg_replace($pattern, '', $contents);
                File::put($file, $updatedContents);
            }
        }
    }
}
if (!function_exists('server_max_upload_size')) {
    function server_max_upload_size() {
        $upload_max_filesize = convertPHPSizeToBytes(ini_get('upload_max_filesize'));
        $post_max_size = convertPHPSizeToBytes(ini_get('post_max_size'));
        $max_upload_size = min($upload_max_filesize, $post_max_size);
        return $max_upload_size;
    }
}
if (!function_exists('convertPHPSizeToBytes')) {
    function convertPHPSizeToBytes($size) {
        $suffix = strtoupper(substr($size, -1));
        $value = (int) substr($size, 0, -1);
        switch ($suffix) {
        case 'G':
            $value *= 1024 * 1024 * 1024;
            break;
        case 'M':
            $value *= 1024 * 1024;
            break;
        case 'K':
            $value *= 1024;
            break;
        }
        return $value;
    }
}
if (!function_exists('checkPurchased')) {
    function checkPurchased($product_id): bool {
        $user = userAuth();
        if (!$user) {
            return false;
        }
        return Order::where('user_id', $user->id)->whereHas('order_products', function ($q) use ($product_id) {
            $q->where('product_id', $product_id);
        })->paymentSuccess()->exists();
    }
}