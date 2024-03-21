<?php

namespace FriendsOfBotble\MercadoPago;

use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient as MercadoPagoClientContract;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\Common\RequestOptions;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\Payment\PaymentClient;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\Payment\PaymentRefundClient;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\Preference\PreferenceClient;
use FriendsOfBotble\MercadoPago\MercadoPago\MercadoPagoConfig;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\PaymentRefund;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\PaymentRefundResult;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Preference;
use Illuminate\Support\Str;

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
