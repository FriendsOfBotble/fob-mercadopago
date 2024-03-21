<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\MerchantOrder;

class ShippingEstimatedDelivery
{
    /** Estimated delivery date. */
    public ?string $date;

    /** Estimated lower delivery time. */
    public ?string $time_from;

    /** Estimated upper delivery time. */
    public ?string $time_to;
}
