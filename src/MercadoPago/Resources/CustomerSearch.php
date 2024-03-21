<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Customer Search class. */
class CustomerSearch extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Search paging. */
    public array|object|null $paging;

    /** Search results. */
    public array|object|null $results;

    private $map = [
        'paging' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Paging",
        'results' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Customer\CustomerSearchResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
