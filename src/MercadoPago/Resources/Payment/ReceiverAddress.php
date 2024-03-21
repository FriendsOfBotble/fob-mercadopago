<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\Payment;

use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Address;

/** ReceiverAddress class. */
class ReceiverAddress extends Address
{
    /** Street name. */
    public ?string $street_name;

    /** Apartment. */
    public ?string $apartment;

    /** City. */
    public ?string $city_name;

    /** Floor. */
    public ?string $floor;
}
