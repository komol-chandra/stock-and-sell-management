<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Branch;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list     = Purchase::query()->with('items');
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
        return view('backend.purchase.index', compact('list', 'searched_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = json_encode(Supplier::where('is_active', 1)->where('is_deleted', 0)->select(['id', 'name', 'phone'])->get());
        $brunches  = json_encode(Branch::where('is_active', 1)->where('is_deleted', 0)->select(['id', 'name', 'phone'])->get());
        return view('backend.purchase.create', compact('suppliers', 'brunches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $purchase       = new Purchase();
            $requested_data = $request->all();
            $purchase->fill($requested_data)->save();
            $purchase_id = $purchase->id;
            foreach ($request->products as $product) {
                Stock::insert([
                    'purchase_id'    => $purchase_id,
                    'product_id'     => $product['id'],
                    'branch_id'      => $product['branch_id'],
                    'purchase_qty'   => $product['purchase_qty'],
                    'purchase_price' => $product['purchase_price'],
                    'sell_price'     => $product['sell_price'],
                    'created_at'     => now(),
                ]);
            }
            DB::commit();
            return $this->respondWithSuccess([
                'code'    => 200,
                'message' => "Purchase Added Successfully",
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondNotFound('System Error');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['items', 'supplier'])->findOrFail($id);
        return view('backend.purchase.view', compact('purchase'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
