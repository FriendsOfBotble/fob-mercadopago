<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources;

use FriendsOfBotble\MercadoPago\MercadoPago\Net\MPResource;

/** PaymentIntentCancel class. */
class PaymentIntentCancel extends MPResource
{
    /** ID of the payment intent.*/
    public ?string $id;
}
