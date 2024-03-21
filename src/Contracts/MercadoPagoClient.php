<?php

namespace FriendsOfBotble\MercadoPago\Contracts;

use MercadoPago\Resources\Payment;
use MercadoPago\Resources\PaymentRefund;
use MercadoPago\Resources\PaymentRefundResult;
use MercadoPago\Resources\Preference;

interface MercadoPagoClient
{
    public function createPreference(array $preference): Preference;

    public function createPayment(array $payment): Payment;

    public function createRefund(string $payment, ?float $amount = null): PaymentRefund;

    public function getPreference(string $id): Preference;

    public function getPayment(string $id): Payment;

    public function getRefund(string $id): PaymentRefundResult;
}
