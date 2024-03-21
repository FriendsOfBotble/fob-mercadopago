<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\PreApprovalPlan;

use FriendsOfBotble\MercadoPago\MercadoPago\Serialization\Mapper;

/** AutoRecurring class. */
class AutoRecurring
{
    /** Class mapper. */
    use Mapper;

    /** Frequency. */
    public ?int $frequency;

    /** Frequency type. */
    public ?string $frequency_type;

    /** Transaction amount. */
    public ?float $transaction_amount;

    /** Currency ID. */
    public ?string $currency_id;

    /** Number of repetitions. */
    public ?int $repetitions;

    /** Free trial details. */
    public ?object $free_trial;

    /** Billing day. */
    public ?int $billing_day;

    /** Billing day proportional. */
    public ?bool $billing_day_proportional;

    /** Transaction amount proportional. */
    public ?float $transaction_amount_proportional;

    public $map = [
        'free_trial' => "FriendsOfBotble\MercadoPago\MercadoPago\Resources\PreApprovalPlan\FreeTrial",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
