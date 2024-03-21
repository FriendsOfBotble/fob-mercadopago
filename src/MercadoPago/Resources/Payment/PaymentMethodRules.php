<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** PaymentMethod class. */
class PaymentMethodRules
{
    /** Class mapper. */
    use Mapper;

    /** Payment discounts. */
    public ?array $discounts;

    /** Payment fine. */
    public array|object|null $fine;

    /** Payment interest. */
    public array|object|null $interest;

    private $map = [
        'discounts' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment\PaymentDiscounts",
        'fine' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment\PaymentFee",
        'interest' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment\PaymentFee",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
