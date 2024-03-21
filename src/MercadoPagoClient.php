<?php

namespace FriendsOfBotble\MercadoPago;

use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient as MercadoPagoClientContract;
use Illuminate\Support\Str;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Payment;
use MercadoPago\Resources\PaymentRefund;
use MercadoPago\Resources\PaymentRefundResult;
use MercadoPago\Resources\Preference;

class MercadoPagoClient implements MercadoPagoClientContract
{
    protected RequestOptions $requestOptions;

    public function __construct(
        protected string $accessToken,
        protected string $environment
    ) {
        MercadoPagoConfig::setAccessToken($this->accessToken);
        MercadoPagoConfig::setRuntimeEnviroment($this->environment);

        $this->requestOptions = new RequestOptions();
        $this->requestOptions->setCustomHeaders([sprintf('X-Idempotency-Key: %s', Str::uuid())]);
    }

    public function createPayment(array $payment): Payment
    {
        $client = new PaymentClient();

        return $client->create($payment, $this->requestOptions);
    }

    public function createRefund(string $payment, ?float $amount = null): PaymentRefund
    {
        $client = new PaymentRefundClient();

        if ($amount) {
            return $client->refund($payment, $amount, $this->requestOptions);
        }

        return $client->refundTotal($payment, $this->requestOptions);
    }

    public function getPayment(string $id): Payment
    {
        $client = new PaymentClient();

        return $client->get($id, $this->requestOptions);
    }

    public function createPreference(array $preference): Preference
    {
        $client = new PreferenceClient();

        return $client->create($preference, $this->requestOptions);
    }

    public function getPreference(string $id): Preference
    {
        $client = new PreferenceClient();

        return $client->get($id, $this->requestOptions);
    }

    public function getRefund(string $id): PaymentRefundResult
    {
        $client = new PaymentRefundClient();

        return $client->list($id, $this->requestOptions);
    }
}
