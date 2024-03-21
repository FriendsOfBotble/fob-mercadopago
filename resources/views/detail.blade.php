<x-core::form.fieldset class="mt-3">
    <x-core::form.label>
        {{ trans('plugins/fob-mercadopago::mercadopago.detail.title') }}
    </x-core::form.label>

    <x-core::datagrid>
        @if($detail->payer->identification->type)
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payer_identification') }}</x-slot:title>
                {{ sprintf('%s: %s', $detail->payer->identification->type, $detail->payer->identification->number) }}
            </x-core::datagrid.item>
        @endif

        @if($detail->payer->first_name || $detail->payer->last_name)
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payer_name') }}</x-slot:title>
                {{ trim(sprintf('%s %s', $detail->payer->first_name, $detail->payer->last_name)) }}
            </x-core::datagrid.item>
        @endif

        @if($detail->payer->phone->number)
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payer_phone') }}</x-slot:title>
                {{ sprintf('%s %s %s', $detail->payer->phone->area_code, $detail->payer->phone->number, $detail->payer->phone->extension) }}
            </x-core::datagrid.item>
        @endif

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payer_email') }}</x-slot:title>
            {{ $detail->payer->email }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payment_id') }}</x-slot:title>
            {{ $detail->id }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payment_method') }}</x-slot:title>
            {{ $detail->payment_method_id }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.payment_type') }}</x-slot:title>
            {{ $detail->payment_type_id }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.cardholder') }}</x-slot:title>
            {{ $detail->card->cardholder->name }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.card') }}</x-slot:title>
            {{ sprintf('**** **** **** %s - %s/%s', $detail->card->last_four_digits, $detail->card->expiration_month, $detail->card->expiration_year) }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.installments') }}</x-slot:title>
            {{ $detail->installments }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.amount') }}</x-slot:title>
            {{ sprintf('%s %s', $detail->transaction_amount, $detail->currency_id) }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.date_created') }}</x-slot:title>
            {{ BaseHelper::formatDateTime($detail->date_created) }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.date_approved') }}</x-slot:title>
            {{ BaseHelper::formatDateTime($detail->date_approved) }}
        </x-core::datagrid.item>

        <x-core::datagrid.item>
            <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.date_last_updated') }}</x-slot:title>
            {{ BaseHelper::formatDateTime($detail->date_last_updated) }}
        </x-core::datagrid.item>
    </x-core::datagrid>

    <x-core::datagrid.item class="mt-3">
        <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.detail.additional_info') }}</x-slot:title>
        <pre>{{ json_encode($detail->additional_info, JSON_PRETTY_PRINT) }}</pre>
    </x-core::datagrid.item>
</x-core::form.fieldset>

@if($detail->status === 'refunded' && isset($detail->refunds))
    <x-core::form.fieldset class="mt-3">
        <x-core::form.label>
            {{ trans('plugins/fob-mercadopago::mercadopago.refund.title') }}
        </x-core::form.label>

        <x-core::datagrid>
            @foreach($detail->refunds as $refund)
                <x-core::datagrid.item>
                    <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.refund.id') }}</x-slot:title>
                    {{ $refund->id }}
                </x-core::datagrid.item>

                <x-core::datagrid.item>
                    <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.amount') }}</x-slot:title>
                    {{ sprintf('%s %s', $refund->amount, $detail->currency_id) }}
                </x-core::datagrid.item>

                <x-core::datagrid.item>
                    <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.refund.refunded_amount') }}</x-slot:title>
                    {{ sprintf('%s %s', $refund->amount_refunded_to_payer, $detail->currency_id) }}
                </x-core::datagrid.item>

                <x-core::datagrid.item>
                    <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.date_created') }}</x-slot:title>
                    {{ BaseHelper::formatDateTime($refund->date_created) }}
                </x-core::datagrid.item>

                <x-core::datagrid.item>
                    <x-slot:title>{{ trans('plugins/fob-mercadopago::mercadopago.refund.status') }}</x-slot:title>
                    {{ $refund->status }}
                </x-core::datagrid.item>
            @endforeach
        </x-core::datagrid>
    </x-core::form.fieldset>

    @include('plugins/payment::partials.view-payment-source', ['payment' => $detail])
@endif
