<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\User;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Metrics class. */
class Metrics
{
    /** Class mapper. */
    use Mapper;

    /** User sales metrics for a specific period. */
    public array|object|null $sales;

    /** User claims metrics for a specific period. */
    public array|object|null $claims;

    /** User delayed handling time metrics for a specific period. */
    public array|object|null $delayed_handling_time;

    /** User cancellations metrics for a specific period. */
    public array|object|null $cancellations;

    public $map = [
        'sales' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\Sales",
        'claims' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\Claims",
        'delayed_handling_time' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\DelayedHandlingTime",
        'cancellations' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\Cancellations",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
