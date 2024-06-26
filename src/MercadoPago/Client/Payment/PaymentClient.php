<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Client\Payment;

use FriendsOfBotble\MercadoPago\MercadoPago\Client\Common\RequestOptions;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\MercadoPagoClient;
use FriendsOfBotble\MercadoPago\MercadoPago\MercadoPagoConfig;
use FriendsOfBotble\MercadoPago\MercadoPago\Net\HttpMethod;
use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPHttpClient;
use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPSearchRequest;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\PaymentSearch;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Serializer;

/** Client responsible for performing payment actions. */
final class PaymentClient extends MercadoPagoClient
{
    private const URL = '/v1/payments';

    private const URL_WITH_ID = '/v1/payments/%s';

    private const URL_SEARCH = '/v1/payments/search';

    /** Default constructor. Uses the default http client used by the SDK or custom http client provided. */
    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * Method responsible for creating payment.
     * @param array $request payment data.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\Payment payment created.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function create(array $request, ?RequestOptions $request_options = null): Payment
    {
        $response = parent::send(self::URL, HttpMethod::POST, json_encode($request), null, $request_options);
        $result = Serializer::deserializeFromJson(Payment::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }

    /**
     * Method responsible for getting payment.
     * @param int $id payment ID.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\Payment payment found.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function get(int $id, ?RequestOptions $request_options = null): Payment
    {
        $response = parent::send(sprintf(self::URL_WITH_ID, strval($id)), HttpMethod::GET, null, null, $request_options);

        $result = Serializer::deserializeFromJson(Payment::class, $response->getContent());

        $result->setResponse($response);

        return $result;
    }
    /**
     * Method responsible for cancel payment.
     * @param int $id payment ID.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\Payment payment canceled.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function cancel(int $id, ?RequestOptions $request_options = null): Payment
    {
        $payload = new PaymentCancelRequest();
        $response = parent::send(sprintf(self::URL_WITH_ID, strval($id)), HttpMethod::PUT, json_encode($payload), null, $request_options);
        $result = Serializer::deserializeFromJson(Payment::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }

    /**
     * Method responsible for capture payment.
     * @param int $id payment ID.
     * @param mixed $amount amount to be captured.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\Payment payment captured.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function capture(int $id, ?float $amount, ?RequestOptions $request_options = null): Payment
    {
        $payload = new PaymentCaptureRequest();
        $payload->transaction_amount = $amount;
        $response = parent::send(sprintf(self::URL_WITH_ID, strval($id)), HttpMethod::PUT, json_encode($payload), null, $request_options);
        $result = Serializer::deserializeFromJson(Payment::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }

    /**
     * Method responsible for search payments.
     * @param \MercadoPago\Net\MPSearchRequest $request search request.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\PaymentSearch search results.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function search(MPSearchRequest $request, ?RequestOptions $request_options = null): PaymentSearch
    {
        $query_params = isset($request) ? $request->getParameters() : null;
        $response = parent::send(self::URL_SEARCH, HttpMethod::GET, null, $query_params, $request_options);
        $result = Serializer::deserializeFromJson(PaymentSearch::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }
}
