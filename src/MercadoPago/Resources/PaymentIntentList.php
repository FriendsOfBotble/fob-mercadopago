<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** PaymentIntentList class. */
class PaymentIntentList extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Events. */
    public array|object|null $events;

    private $map = [
        'events' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Point\Events",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
