<?php

namespace FriendsOfBotble\MercadoPago\MercadoPago\Resources\User;

use FriendsOfBotble\MercadoPago\MercadoPago\Resources\Common\Phone as Base;

/** Phone class. */
class Phone extends Base
{
    /** Indicates whether the user's phone number is verified (true/false). */
    public ?bool $verified;
}
