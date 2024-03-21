<?php

namespace FriendsOfBotble\MercadoPago\Http\Requests;

use Botble\Support\Http\Requests\Request;

class WebhookRequest extends Request
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'type' => ['required', 'string', 'in:payment'],
            'action' => ['required', 'string', 'in:payment.created,payment.updated'],
            'data.id' => ['required', 'string'],
        ];
    }
}
