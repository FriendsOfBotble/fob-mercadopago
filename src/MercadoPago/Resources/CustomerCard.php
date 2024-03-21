<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Customer Card class. */
class CustomerCard extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Id of the card. */
    public ?string $id;

    /** Id of the customer. */
    public ?string $customer_id;

    /** Month the card expires. */
    public ?int $expiration_month;

    /** Year the card expires. */
    public ?int $expiration_year;

    /** First six digits of the card. */
    public ?string $first_six_digits;

    /** Last four digits of the card. */
    public ?string $last_four_digits;

    /** Data related to the chosen payment method. */
    public array|object|null $payment_method;

    /** Security code of the card. */
    public array|object|null $security_code;

    /** Card issuer. */
    public array|object|null $issuer;

    /** Data related to the holder of the card, usually the customer. */
    public array|object|null  $cardholder;

    /** Creation date of the record. */
    public ?string $date_created;

    /** Date the record was last updated. */
    public ?string $date_last_updated;

    /** Id of the user. */
    public ?string $user_id;

    /** Flag indicating if this is a record from production or test environment. */
    public ?bool $live_mode;

    /** Card number is. */
    public ?string $card_number_id;

    private $map = [
        'payment_method' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Customer\PaymentMethod",
        'security_code' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Customer\SecurityCode",
        'issuer' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Customer\Issuer",
        'cardholder' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Customer\Cardholder",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
