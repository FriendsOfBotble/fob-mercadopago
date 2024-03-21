<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Payment Refund Result class. */
class PaymentRefundResult extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Data. */
    public array|object|null $data;

    private $map = [
        'data' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment\PaymentRefundListResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
