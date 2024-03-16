<?php

use Illuminate\Support\Str;

if (!function_exists('productInfo')) {
    function productInfo($id)
    {
        return \App\Models\Product::select(['name', 'sku'])->where('id', $id)->first();
    }
}

if (!function_exists('noImg')) {
    function noImg()
    {
        return asset('uploads/no-img.png');
    }
}

if (!function_exists('generateUniqueSkuCode')) {
    function generateUniqueSkuCode(string $string): string
    {
        $storeName = explode(" ", $string);
        $prefix    = "";
        foreach ($storeName as $value) {
            $prefix .= $value[0];
        }
        return strtoupper($prefix) . '-' . strtoupper(Str::random(4)) . '-' . random_int(100000, 999999);
    }
}

if (!function_exists('brunchId')) {
    function brunchId()
    {
        return auth()->user()->branch_id;
    }
}
