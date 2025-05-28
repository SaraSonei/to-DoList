<?php

use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

if (!function_exists('formatDateForDisplay')) {
    function formatDateForDisplay($date): string
    {
        return config('app.datepicker_locale') === 'jalali'
            ? Jalalian::fromDateTime($date)->format('Y-m-d')
            : Carbon::parse($date)->format('Y-m-d');
    }

    function isJalali(): bool
    {
        return config('app.datepicker_locale') === 'jalali';
    }
}

