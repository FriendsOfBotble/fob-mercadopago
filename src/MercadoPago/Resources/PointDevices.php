<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** PointDevices class. */
class PointDevices extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Search paging. */
    public array|object|null $paging;

    /** Devices. */
    public array|object|null $devices;

    private $map = [
        'paging' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Paging",
        'devices' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Point\Device",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
