<?php

namespace FriendsOfBotble\MercadoPago\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment as PaymentModel;
use Botble\Payment\Supports\PaymentHelper;
use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient;
use FriendsOfBotble\MercadoPago\Facades\MercadoPagoPayment;
use FriendsOfBotble\MercadoPago\Http\Requests\PaymentRequest;
use FriendsOfBotble\MercadoPago\Http\Requests\WebhookRequest;
use FriendsOfBotble\MercadoPago\MercadoPago\Exceptions\MPApiException;
use Botble\Hotel\Models\Booking;
use Illuminate\Support\Arr;

class MercadopagoController extends BaseController
{
    public function callback(PaymentRequest $request, MercadoPagoClient $mercadoPagoClient)
    {
        try {
            $payment = $mercadoPagoClient->getPayment($request->input('payment_id'));

            do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
                'amount' => $payment->transaction_amount,
                'currency' => $payment->currency_id,
                'charge_id' => $payment->id,
                'payment_channel' => MercadoPagoPayment::getId(),
                'status' => $this->convertStatus($payment->status),
                'customer_id' => $payment->metadata->customer_id,
                'customer_type' => $payment->metadata->customer_type,
                'order_id' => (array) $payment->metadata->order_id,
            ]);

            if (is_plugin_active('hotel')) {
                $booking = Booking::query()
                    ->select('transaction_id')
                    ->find(Arr::first($payment->metadata->order_id));

                if (! $booking) {
                    return $this
                        ->httpResponse()
                        ->setNextUrl(PaymentHelper::getCancelURL())
                        ->setMessage(__('Checkout failed!'));
                }

                return $this
                    ->httpResponse()
                    ->setNextUrl(PaymentHelper::getRedirectURL($booking->transaction_id))
                    ->setMessage(__('Checkout successfully!'));
            }

            $nextUrl = PaymentHelper::getRedirectURL();

            if (is_plugin_active('job-board') || is_plugin_active('real-estate')) {
                $nextUrl = $nextUrl . '?charge_id=' . $payment->id;
            }

            return $this
                ->httpResponse()
                ->setNextUrl($nextUrl)
                ->setMessage(trans('plugins/payment::payment.checkout_success'));
        } catch (MPApiException $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage($e->getMessage());
        }
    }

    public function webhook(WebhookRequest $request, MercadoPagoClient $mercadoPagoClient)
    {
        try {
            $payment = $mercadoPagoClient->getPayment($request->input('data.id'));

            $transaction = PaymentModel::query()
                ->where('charge_id', $payment->id)
                ->first();

            if (! $transaction || $transaction->status !== PaymentStatusEnum::PENDING) {
                abort(404);
            }

            $transaction->update(['status' => $this->convertStatus($payment->status)]);

            return response()->json();
        } catch (MPApiException) {
            abort(404);
        }
    }

    protected function convertStatus(string $status): string
    {
        return match ($status) {
            'approved' => PaymentStatusEnum::COMPLETED,
            'pending', 'in_process' => PaymentStatusEnum::PENDING,
            default => PaymentStatusEnum::FAILED,
        };
    }
}
