<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function orderList(Request $request)
    {
        $list     = Order::query()->with('items');
        $per_page = $request->per_page ?? 10;
        $sorting  = $request->sorting ?? 'latest';
        if ($sorting === 'latest') {
            $list = $list->latest();
        } else if ($sorting === 'oldest') {
            $list = $list->oldest();
        } else if ($sorting === 'high_to_low_price') {
            $list = $list->orderBy('grand_total', 'DESC');
        } else if ($sorting === 'low_to_high_price') {
            $list = $list->orderBy('grand_total', 'ASC');
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
            $list = $list->where('invoice_id', 'LIKE', trim($request->search) . '%');
        }
        $list          = $list->paginate($per_page)->withQueryString();
        $searched_data = [
            'per_page'   => $per_page,
            'sorting'    => $sorting,
            'select_day' => $request->select_day,
        ];
        return view('backend.report.sell-point.index', compact('list', 'searched_data'));
    }
    public function orderView($id)
    {
        $order = Order::with(['items'])->find($id);
        return view('backend.report.sell-point.view', compact('order'));
    }
    public function topCustomer(){
        $list = User::with('orders')
            ->withCount(['orders as total_amount' => function ($query) {
                $query->select(DB::raw('sum(grand_total)'));
            }])
            ->where('role_id',3)
            ->orderByDesc('total_amount')
            ->paginate();
        return view('backend.report.top-user', compact('list' ));

    }
    public function topSellProduct(Request $request)
    {
        $list     = $topSellingProducts = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('sum(qty)'));
        }])
            ->orderByDesc('total_sold');
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
        return view('backend.report.top-sell-product', compact('list', 'searched_data'));
    }
}
