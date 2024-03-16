<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductInfoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($sku)
    {
        $product = Product::query()->with(['stock', 'unit'])->where('sku', $sku)->first();
        if ($product === null) {
            return $this->respondNotFound('Product Not Found');
        }
        $data = [
            'id'             => $product?->id,
            'name'           => $product?->name,
            'stock'          => $product?->stock->sum('available_qty'),
            'purchase_qty'   => 1,
            'unit'           => $product?->unit->name,
            'purchase_price' => '',
            'total_price'    => '',
        ];
        return $this->respondWithSuccess([
            'code'    => 200,
            'data'    => $data,
            'message' => "Product Added Successfully",
        ]);
    }
}
