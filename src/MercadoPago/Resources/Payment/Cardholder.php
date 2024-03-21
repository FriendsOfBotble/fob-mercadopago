<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Cardholder class. */
class Cardholder
{
    /** Class mapper. */
    use Mapper;

    /** Cardholder Name. */
    public ?string $name;

    /** Cardholder identification. */
    public array|object|null $identification;

    private $map = [
        'identification' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment\Identification",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
