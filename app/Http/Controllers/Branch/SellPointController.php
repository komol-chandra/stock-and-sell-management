<?php
namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellPointController extends Controller
{
    public function getProductList()
    {
        $allProducts = Product::with(['branchWishStock', 'branchWishStockItem', 'unit', 'category', 'brand'])
            ->where('is_deleted', 0)
            ->select('id', 'name', 'short_description', 'image', 'unit_id', 'category_id', 'brand_id')
            ->get();

// Step 2: Transform the format
        $transformedItems = $allProducts->map(function ($item) {
            return [
                'id'                 => $item->id,
                'name'               => $item->name,
                'price'              => 500,
                'short_description'  => Str::limit($item->short_description, 50, '...'),
                'image'              => $item->image ? asset($item->image) : noImg(),
                'unit_name'          => $item->unit->name,
                'category_name'      => $item->category->name,
                'brand_name'         => $item->brand->name,
                'stock_qty'          => $item->branchWishStock->sum('available_qty'),
                'purchase_qty'       => 0,
                'purchase_price'     => 0,
                'purchase_sub_total' => 0,
                'purchase_branch_id' => null,
                'purchase_stock_id'  => null,
                'branch_stock_info'  => $item->branchWishStockItem,
            ];
        });

        $transformedItems = $transformedItems->filter(function ($item) {
            return $item['stock_qty'] > 0;
        });

        $perPage = 25; // Set your desired items per page value
        $currentPage = request()->input('page', 1);
        $pagedItems = array_slice($transformedItems->all(), ($currentPage - 1) * $perPage, $perPage);
        $paginatedList = new \Illuminate\Pagination\LengthAwarePaginator($pagedItems, count($transformedItems), $perPage, $currentPage);


        return response()->json(['products' => $paginatedList]);
    }

    public function orderList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search  = $request->input('search');

        $query = Order::query();

        if ($search) {
            $query->where('invoice_id', 'LIKE', "%$search%")
                ->orWhere('date', 'LIKE', "%$search%");
        }
        $orders = $query->paginate($perPage);

        return response()->json($orders);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
        return view('branch.sell-point.index', compact('list', 'searched_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch.sell-point.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $order          = new Order();
            $requested_data = $request->all();
            $order->fill($requested_data)->save();
            $order_id = $order->id;
            foreach ($request->products as $product) {
                OrderItem::insert([
                    'order_id'   => $order_id,
                    'product_id' => $product['id'],
                    'stock_id'   => $product['purchase_stock_id'],
                    'branch_id'  => $product['purchase_branch_id'],
                    'qty'        => $product['purchase_qty'],
                    'price'      => $product['purchase_price'],
                    'sub_total'  => $product['purchase_sub_total'],
                    'created_at' => now(),
                ]);
                $stock = Stock::find($product['purchase_stock_id']);
                $stock->increment('sell_qty', $product['purchase_qty']);
                $stock->save();
            }
            DB::commit();
            return $this->respondWithSuccess([
                'code'    => 200,
                'message' => "Order Created Successfully",
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
        $order = Order::with(['items'])->find($id);
        return view('branch.sell-point.view', compact('order'));
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
