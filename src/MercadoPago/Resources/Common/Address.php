<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Address class. */
class Address
{
    /** Class mapper. */
    use Mapper;

    /** Addess ID. */
    public ?string $id;

    /** Zip code. */
    public ?string $zip_code;

    /** Street name. */
    public ?string $street_name;

    /** Street number. */
    public ?int $street_number;

    /** City. */
    public array|object|null $city;

    private $map = [
        'city' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\City",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
