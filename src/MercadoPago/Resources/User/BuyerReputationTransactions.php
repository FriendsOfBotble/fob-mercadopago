<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\User;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** BuyerReputationTransactions class. */
class BuyerReputationTransactions
{
    /** Class mapper. */
    use Mapper;

    /** User metrics for canceled transactions. */
    public array|object|null $canceled;

    /** The number of completed transactions. */
    public $completed;

    /** User metrics for transactions not yet rated. */
    public array|object|null $not_yet_rated;

    /** The transaction period (e.g., "historic"). */
    public ?string $period;

    /** User metrics for unrated transactions. */
    public array|object|null $unrated;

    /** Total of transactions. */
    public $total;

    public $map = [
        'canceled' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\BuyerReputationCancelled",
        'not_yet_rated' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\BuyerReputationNotYetRated",
        'unrated' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\BuyerReputationUnrated",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
