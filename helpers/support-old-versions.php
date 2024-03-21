<?php

if (! function_exists('get_payment_setting_key')) {
    function get_payment_setting_key(string $key, string|null $type = null): string
    {
        $key = $type ? "payment_{$type}_{$key}" : "payment_$key";

        return apply_filters('payment_setting_key', $key);
    }
}
