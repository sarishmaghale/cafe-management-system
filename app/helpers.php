<?php

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Station;
use Spatie\Permission\Models\Role;

if (!function_exists('getTodayDate')) {
    function getTodayDate()
    {
        return Carbon::today()->toDateString();
    }
}

if (!function_exists('calculateTotalAmount')) {
    function calculateTotalAmount($data)
    {
        $total = $data->sum(function ($item) {
            return $item->quantity * $item->product->product_price;
        });
        return $total;
    }
}
if (!function_exists('getLanguages')) {
    function getLanguages()
    {
        $languages = [
            ['code' => 'en', 'name' => 'English'],
            ['code' => 'ne', 'name' => 'Nepali'],
            ['code' => 'fr', 'name' => 'French'],
            ['code' => 'es', 'name' => 'Spanish'],
            ['code' => 'de', 'name' => 'German'],
            ['code' => 'it', 'name' => 'Italian'],
            ['code' => 'pt', 'name' => 'Portuguese'],
            ['code' => 'ru', 'name' => 'Russian'],
            ['code' => 'ja', 'name' => 'Japanese'],
            ['code' => 'ko', 'name' => 'Korean'],
            ['code' => 'zh-CN', 'name' => 'Chinese (Simplified)'],
            ['code' => 'ar', 'name' => 'Arabic'],
            ['code' => 'hi', 'name' => 'Hindi'],
            ['code' => 'bn', 'name' => 'Bengali'],
            ['code' => 'pa', 'name' => 'Punjabi'],
            ['code' => 'vi', 'name' => 'Vietnamese'],
            ['code' => 'tr', 'name' => 'Turkish'],
            ['code' => 'pl', 'name' => 'Polish'],
            ['code' => 'id', 'name' => 'Indonesian'],
            ['code' => 'th', 'name' => 'Thai'],
            ['code' => 'sv', 'name' => 'Swedish'],
            ['code' => 'no', 'name' => 'Norwegian'],
            ['code' => 'fi', 'name' => 'Finnish'],
            ['code' => 'da', 'name' => 'Danish'],
            ['code' => 'cs', 'name' => 'Czech'],
            ['code' => 'ro', 'name' => 'Romanian'],
            ['code' => 'hu', 'name' => 'Hungarian'],
            ['code' => 'el', 'name' => 'Greek'],
            ['code' => 'he', 'name' => 'Hebrew'],
            ['code' => 'ms', 'name' => 'Malay'],
        ];
        return $languages;
    }
}
if (!function_exists('getTotalProducts')) {
    function getTotalProducts()
    {
        return Product::count();
    }
}
if (!function_exists('getTotalStations')) {
    function getTotalStations()
    {
        return Station::count();
    }
}
if (!function_exists('getRoles')) {
    function getRoles()
    {
        return Role::all();
    }
}
if (!function_exists('getDailySales')) {
    function getDailySales($date)
    {
        static $cache = [];
        // If we already fetched sales for this date, return cached value
        if (isset($cache[$date])) {
            return $cache[$date];
        }
        // Otherwise, query the database
        $totalSales = \App\Models\Billing::whereDate('updated_at', $date)
            ->where('status', 1)
            ->sum('total');
        // Store result in cache for this request
        $cache[$date] = $totalSales;

        return $totalSales;
    }
}
