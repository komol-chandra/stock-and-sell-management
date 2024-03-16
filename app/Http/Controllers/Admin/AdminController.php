<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
        $total_order_amount = Order::where('is_deleted',0)->sum('grand_total');
        $total_purchase_amount = Purchase::where('is_deleted',0)->sum('grand_total');
        $profit = $total_order_amount - $total_purchase_amount;
        $report=[
            'product_count'  => Product::where('is_deleted',0)->count('id'),
            'purchases_count'  => Purchase::where('is_deleted',0)->count('id'),
            'user_count'  => User::where('is_deleted',0)->count('id'),
            'branch_count'  => Branch::where('is_deleted',0)->count('id'),
            'brand_count'  => Brand::where('is_deleted',0)->count('id'),
            'category_count'  => Category::where('is_deleted',0)->count('id'),
            'supplier_count'  => Supplier::where('is_deleted',0)->count('id'),
            'order_count'  => Order::where('is_deleted',0)->count('id'),
            'purchase_count'  => Purchase::where('is_deleted',0)->count('id'),
            'total_order_amount'  => number_format($total_order_amount, 2, '.', ','),
            'total_purchase_amount'  => number_format($total_purchase_amount, 2, '.', ','),
            'total_profit_amount'  => number_format($profit, 2, '.', ','),
        ];
        return view('backend.dashboard.main', compact('report' ));
    }
}
