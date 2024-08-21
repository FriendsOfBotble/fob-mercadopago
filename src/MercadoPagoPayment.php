<?php

namespace FriendsOfBotble\MercadoPago;

use Botble\Language\Facades\Language;
use Botble\Payment\Models\Payment;
use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient;
use FriendsOfBotble\MercadoPago\MercadoPago\Exceptions\MPApiException;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\PaymentRefund;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MercadoPagoPayment
{
    public function getId(): string
    {
        return 'mercadopago';
    }

    public function getDisplayName(): string
    {
        return 'Mercado Pago';
    }

    public function authorize(array $data, Request $request)
    {
        if (! in_array($data['currency'], $this->supportedCurrencies())) {
            return [
                'error' => true,
                'message' => __(
                    ":name doesn't support :currency. List of currencies supported by :name: :currencies.",
                    [
                        'name' => 'MercadoPago',
                        'currency' => $data['currency'],
                        'currencies' => implode(', ', $this->supportedCurrencies()),
                    ]
                ),
            ];
        }

        $data = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

        try {
            /** @var Preference $preference */
            $preference = app(MercadoPagoClient::class)
                ->createPreference([
                    'external_reference' => $data['order_id'][0],
                    'auto_return' => 'all',
                    'installments' => 1,
                    'default_installments' => 1,
                    'items' => array_map(fn ($item) => [
                        'id' => Arr::get($item, 'id'),
                        'title' => Arr::get($item, 'name'),
                        'picture_url' => Arr::get($item, 'image'),
                        'currency_id' => Arr::get($item, 'currency'),
                        'quantity' => (int) $quantity = Arr::get($item, 'qty'),
                        'unit_price' => Arr::get($item, 'price_per_order') / $quantity,
                    ], $data['products']),
                    'payer' => [
                        'name' => $data['address']['name'],
                        'email' => $data['address']['email'],
                        'phone' => [
                            'number' => $data['address']['phone'],
                        ],
                    ],
                    'back_urls' => [
                        'success' => route('payment.mercadopago.callback'),
                        'failure' => route('payment.mercadopago.callback'),
                        'pending' => route('payment.mercadopago.callback'),
                    ],
                    'notification_url' => route('payment.mercadopago.webhook'),
                    'address' => [
                        'zip_code' => $data['address']['zip_code'] ?? 'none',
                        'street_name' => $data['address']['address'] ?? 'none',
                    ],
                    'metadata' => [
                        'order_id' => $data['order_id'],
                        'customer_id' => $data['customer_id'],
                        'customer_type' => $data['customer_type'],
                        'checkout_token' => $data['checkout_token'],
                    ],
                ]);

            echo view('plugins/fob-mercadopago::checkout', [
                'preferenceId' => $preference->id,
                'publicKey' => get_payment_setting('public_key', 'mercadopago'),
                'locale' => $this->getLocale(),
            ])->render();
            exit();
        } catch (MPApiException $e) {
            return [
                'error' => true,
                'message' => 'API error: ' . $e->getApiResponse()->getContent()['message'] ?? $e->getMessage(),
            ];
        }
    }

    public function refundOrder(string $chargeId, float $amount, array $options = []): array
    {
        $payment = Payment::query()
            ->where('charge_id', $chargeId)
            ->firstOrFail();

        if ((float) $payment->amount !== $amount) {
            return [
                'error' => true,
                'message' => trans('plugins/fob-mercadopago::mercadopago.not_supported_partial_refund'),
            ];
        }

        try {
            /** @var PaymentRefund $response */
            $response = app(MercadoPagoClient::class)->createRefund($chargeId);

            return [
                'error' => false,
                'message' => $response->status,
                'data' => (array) $response,
            ];

        } catch (MPApiException $e) {
            return [
                'error' => true,
                'message' => json_encode($e->getApiResponse()->getContent()),
            ];
        }
    }

    public function getLocale(): string
    {
        $locale = 'en-US';

        if (is_plugin_active('language')) {
            $currentLocale = str_replace('_', '-', Language::getCurrentLocaleCode());
        } else {
            $currentLocale = str_replace('_', '-', app()->getLocale());
        }

        return in_array($currentLocale, $this->supportedLocales()) ? $currentLocale : $locale;
    }

    public function getSupportRefundOnline(): bool
    {
        return true;
    }

    public function supportedCurrencies(): array
    {
        return [
            'ARS',
            'BRL',
            'CLP',
            'COP',
            'MXN',
            'PEN',
            'UYU',
        ];
    }

    public function supportedLocales(): array
    {
        return [
            'es-AR',
            'es-CL',
            'es-CO',
            'es-MX',
            'es-VE',
            'es-UY',
            'es-PE',
            'pt-BR',
            'en-US',
        ];
    }
}
