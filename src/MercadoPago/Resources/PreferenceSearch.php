<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;
use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** PreferenceSearch class. */
class PreferenceSearch extends MPResource
{
    /** Class mapper. */
    use Mapper;

    /** Search elements. */
    public array $elements;

    /** Search next offset. */
    public ?int $next_offset;

    /** Search total. */
    public ?int $total;

    private $map = [
        'elements' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\Preference\PreferenceListResult",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
