<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** PaymentMethodResult class. */
class PaymentMethodResult extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Payment Method Result data. */
    public array|object|null $data;

    private $map = [
        'data' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\PaymentMethod\PaymentMethodListResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
