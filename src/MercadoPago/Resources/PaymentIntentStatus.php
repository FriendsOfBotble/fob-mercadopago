<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;

/** PaymentIntentStatus class. */
class PaymentIntentStatus extends MPResource
{
    /** Status of payment intent. */
    public ?string $status;

    /** Date created. */
    public ?string $created_on;
}
