<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Client\IdentificationType;

use FriendsOfBotble\MercadoPago\MercadoPago\Client\Common\RequestOptions;
use FriendsOfBotble\MercadoPago\MercadoPago\Client\MercadoPagoClient;
use FriendsOfBotble\MercadoPago\MercadoPago\MercadoPagoConfig;
use FriendsOfBotble\MercadoPago\MercadoPago\Net\HttpMethod;
use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPHttpClient;
use FriendsOfBotble\MercadoPago\MercadoPago\Resources\IdentificationTypeResult;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Serializer;

/** Client responsible for performing identification type actions. */
final class IdentificationTypeClient extends MercadoPagoClient
{
    private const URL = '/v1/identification_types';

    /** Default constructor. Uses the default http client used by the SDK or custom http client provided. */
    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * Method responsible for list identification types.
     * @param \MercadoPago\Client\Common\RequestOptions request options to be sent.
     * @return \MercadoPago\Resources\IdentificationTypeResult identification type found.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function list(?RequestOptions $request_options = null): IdentificationTypeResult
    {
        $response = parent::send(self::URL, HttpMethod::GET, null, null, $request_options);
        $result_data = ['data' => $response->getContent()];
        $result = Serializer::deserializeFromJson(IdentificationTypeResult::class, $result_data);
        $result->setResponse($response);

        return $result;
    }
}
