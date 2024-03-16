<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $products  = Product::count('id');
        $purchases = OrderItem::where('branch_id', brunchId())->count('id');
        return view('branch.dashboard.main', compact('products', 'purchases'));
    }

    public function productStockList(Request $request)
    {
        $list     = Product::query()->with('branchWishStock')->where('is_deleted', 0);
        $per_page = $request->per_page ?? 10;
        $sorting  = $request->sorting ?? 'latest';
        if ($sorting === 'latest') {
            $list = $list->latest();
        } else if ($sorting === 'oldest') {
            $list = $list->oldest();
        }
        if ($request->select_day) {
            if ($request->select_day == 'today') {
                $list = $list->thisDay();
            } elseif ($request->select_day == 'thisWeek') {
                $list = $list->thisWeek();
            } elseif ($request->select_day == 'thisMonth') {
                $list = $list->thisMonth();
            } elseif ($request->select_day == 'thisYear') {
                $list = $list->thisYear();
            }
        }

        if ($request->search) {
            $list = $list->fullSearch(trim($request->search));
        }
        $list          = $list->paginate($per_page)->withQueryString();
        $searched_data = [
            'per_page'   => $per_page,
            'sorting'    => $sorting,
            'select_day' => $request->select_day,
        ];
        return view('branch.product.index', compact('list', 'searched_data'));
    }
}
