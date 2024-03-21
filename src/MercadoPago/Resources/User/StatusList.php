<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\User;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** StatusList class. */
class StatusList
{
    /** Class mapper. */
    use Mapper;

    /** Indicates whether buying is allowed (true/false). */
    public ?bool $allow;

    /** Buy status codes. */
    public array|object|null $codes;

    /** User immediate payment data for buying. */
    public array|object|null $immediate_payment;

    public $map = [
        'immediate_payment' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\StatusBuyImmediatePayment",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
