<?php

if (!function_exists('formatIDR')) {
    function formatIDR($amount)
    {
        return 'IDR ' . number_format($amount, 0, ',', '.');
    }
}