<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\Preference;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Payer class. */
class Payer
{
    /** Class mapper. */
    use Mapper;

    /** Payer's name. */
    public ?string $name;

    /** Payer's surname. */
    public ?string $surname;

    /** Payer's email. */
    public ?string $email;

    /** Payer's phone. */
    public array|object|null $phone;

    /** Payer's identification. */
    public array|object|null $identification;

    /** Payer's address. */
    public array|object|null $address;

    /** Date of creation of the payer user. */
    public ?string $date_created;

    /** Date of the last purchase. */
    public ?string $last_purchase;

    private $map = [
        'identification' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Identification",
        'phone' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Phone",
        'address' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Address",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
