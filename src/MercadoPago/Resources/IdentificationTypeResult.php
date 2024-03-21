<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** IdentificationTypeResult class. */
class IdentificationTypeResult extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Identification Type Result data. */
    public array|object|null $data;

    private $map = [
        'data' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\IdentificationType\IdentificationTypeListResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
