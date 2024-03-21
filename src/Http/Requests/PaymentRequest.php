<?php

namespace FriendsOfBotble\MercadoPago\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PaymentRequest extends Request
{
    public function rules(): array
    {
        return [
            'preference_id' => ['required', 'string'],
            'payment_id' => ['required', 'integer'],
            'status' => ['required', 'string'],
            'external_reference' => ['required', 'string'],
            'merchant_order_id' => ['required', 'string'],
        ];
    }
}
