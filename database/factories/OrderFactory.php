<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('role_id', 3)->inRandomOrder()->first();

        // Create a new Order
        $order = [
            "customer_name" => $user->name,
            "customer_phone" => $user->phone,
            "customer_id" => $user->id,
            'is_active' => 1,
            'is_deleted' => 0,
            'invoice_id' => $this->generateInvoiceId(),
            "date" => $this->randomDate(),
            'note' => $this->faker->sentence(160, true),
            'created_at' => now(),
        ];

        // Create associated OrderItems (at least 5)
        $branchId = $user->id % 2 === 0 ? 1 : 2;
        $orderItems = [];
        $productQty = rand(2, 4);
        for ($i = 1; $i < 5; $i++) {
            $productStock = Stock::inRandomOrder()
                ->where('branch_id', $branchId)
                ->where('purchase_qty', '<=', $productQty)
                ->first();
            if ($productStock) {

                $orderItems[] = new OrderItem([
                    'product_id' => $productStock->product_id,
                    'branch_id' => $branchId,
                    'qty' => 3,
                    'price' => $productStock->sell_price,
                    'sub_total' => $productQty * $productStock->sell_price,
                ]);
            }
        }
        // Calculate the total cost for the Order based on OrderItems
        $order['grand_total'] = collect($orderItems)->sum('sub_total');
        // Save the Order
        $createdOrder = Order::create($order);

        // Associate the OrderItems with the Order
        $createdOrder->items()->saveMany($orderItems);

        return $order;
    }

    function generateInvoiceId(): string
    {
        $id = Order::latest()->first()->id ?? 0;
        $prefix = "KiRi2Ka";
        $randomPart2 = random_int(10000, 99999);
        $randomPart3 = Str::random(4);
        return $prefix . '-' . $id . $randomPart2 . '-' . $randomPart3;
    }

    function randomDate($lastYear = 3): Carbon
    {
        $startDate = Carbon::now()->subYears($lastYear);
        $endDate = Carbon::now();
        return Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp));
    }
}
