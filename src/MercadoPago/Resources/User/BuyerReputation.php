<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\User;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** BuyerReputation class. */
class BuyerReputation
{
    /** Class mapper. */
    use Mapper;

    /** The number of canceled transactions. */
    public ?int $canceled_transactions;

    /** User tags associated with the buyer reputation. */
    public ?array $tags;

    /** User transaction metrics and statistics. */
    public array|object|null $transactions;

    public $map = [
        'transactions' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\User\BuyerReputationTransactions",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
