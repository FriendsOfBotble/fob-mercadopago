<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** Merchant Order Search class. */
class MerchantOrderSearch extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Search elements. */
    public array|object|null $elements;

    /** Search next offset. */
    public ?int $next_offset;

    /** Search total. */
    public ?int $total;

    private $map = [
        'elements' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\MerchantOrder\MerchantOrderSearchResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
