<?php

namespace FriendsOfBotble\MercadoPago\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Ecommerce\Models\Currency as CurrencyEcommerce;
use Botble\JobBoard\Models\Currency as CurrencyJobBoard;
use Botble\RealEstate\Models\Currency as CurrencyRealEstate;
use Botble\Hotel\Models\Currency as CurrencyHotel;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Models\Payment;
use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient as MercadoPagoClientContract;
use FriendsOfBotble\MercadoPago\Facades\MercadoPagoPayment;
use FriendsOfBotble\MercadoPago\Forms\MercadoPagoPaymentMethodForm;
use FriendsOfBotble\MercadoPago\MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(PAYMENT_METHODS_SETTINGS_PAGE, function (string $html): string {
            return $html . MercadoPagoPaymentMethodForm::create()->renderForm();
        }, 999);

        add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, function (?string $html, array $data): string {
            if (! get_payment_setting('status', MercadoPagoPayment::getId())) {
                return $html;
            }

            $data = [
                ...$data,
                'paymentId' => MercadoPagoPayment::getId(),
                'paymentDisplayName' => MercadoPagoPayment::getDisplayName(),
                'supportedCurrencies' => MercadoPagoPayment::supportedCurrencies(),
            ];

            $view = 'plugins/fob-mercadopago::payment-method';

            // Support old versions
            if (! view()->exists('plugins/ecommerce::components.fronts.checkout.payment-method')) {
                $view = 'plugins/fob-mercadopago::support-old-versions.payment-method';
            }

            return $html . view($view, $data)->render();
        }, 999, 2);

        add_filter(PAYMENT_FILTER_GET_SERVICE_CLASS, function (string $class, string $payment) {
            if ($payment === MercadoPagoPayment::getId()) {
                $class = \FriendsOfBotble\MercadoPago\MercadoPagoPayment::class;
            }

            return $class;
        }, 999, 2);

        add_filter(BASE_FILTER_ENUM_ARRAY, function (array $values, string $enum) {
            if ($enum === PaymentMethodEnum::class) {
                $values['MERCADEPAGO'] = MercadoPagoPayment::getId();
            }

            return $values;
        }, 999, 2);

        add_filter(BASE_FILTER_ENUM_LABEL, function (string $value, string $enum) {
            if ($enum === PaymentMethodEnum::class && $value === MercadoPagoPayment::getId()) {
                $value = MercadoPagoPayment::getDisplayName();
            }

            return $value;
        }, 999, 2);

        add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, function (array $data, Request $request) {
            if ($data['type'] !== MercadoPagoPayment::getId()) {
                return $data;
            }

            $currentCurrency = get_application_currency();

            $data = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

            if (! in_array(strtoupper($currentCurrency->title), MercadoPagoPayment::supportedCurrencies())) {
                $currency = match (true) {
                    is_plugin_active('ecommerce') => CurrencyEcommerce::class,
                    is_plugin_active('job-board') => CurrencyJobBoard::class,
                    is_plugin_active('real-estate') => CurrencyRealEstate::class,
                    is_plugin_active('hotel') => CurrencyHotel::class,
                    default => null,
                };

                $supportedCurrency = $currency::query()
                    ->whereIn('title', MercadoPagoPayment::supportedCurrencies())
                    ->first();

                if ($supportedCurrency) {
                    $data['currency'] = strtoupper($supportedCurrency->title);
                    if ($currentCurrency->is_default) {
                        $data['amount'] = $data['amount'] * $supportedCurrency->exchange_rate;
                    } else {
                        $data['amount'] = format_price(
                            $data['amount'] / $currentCurrency->exchange_rate,
                            $currentCurrency,
                            true
                        );
                    }
                }
            }

            $result = MercadoPagoPayment::authorize($data, $request);

            return [...$data, ...$result];
        }, 999, 2);

        add_filter(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, function (string $html, Payment $payment) {
            if ($payment->payment_channel != MercadoPagoPayment::getId()) {
                return $html;
            }

            $client = $this->app->make(MercadoPagoClientContract::class);

            try {
                $detail = $client->getPayment($payment->charge_id);

                if ($detail->status === 'refunded') {
                    $detail->refunds = $client->getRefund($payment->charge_id)->data;
                }

                return $html . view('plugins/fob-mercadopago::detail', compact('payment', 'detail'))->render();
            } catch (MPApiException) {
                return $html;
            }
        }, 999, 2);
    }
}
