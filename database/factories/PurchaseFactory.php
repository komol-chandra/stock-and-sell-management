<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a new Purchase
        $purchase = [
            "date"  => $this->randomDate(),
            'is_active' => 1,
            'is_deleted' => 0,
            'invoice_id' => $this->generateInvoiceId(),
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
            'transportation_cost' => rand(200, 500),
            'grand_total' => Unit::all()->random()->id,
            'note' => $this->faker->sentence(160, true),
            'created_at' => now(),
        ];
        // Create associated Stocks (at least 5)
        $stocks = Stock::factory()->times(rand(5, 10))->make([
            'product_id' => Product::inRandomOrder()->first()->id,
            'branch_id' => Branch::inRandomOrder()->first()->id,
            'purchase_qty' => rand(200, 500),
            'purchase_price' => rand(200, 500),
            'sell_price' => rand(550,750),
        ]);

        $purchase['grand_total'] = $stocks->sum(function ($stock) {
                return $stock->purchase_qty * $stock->purchase_price;
            }) + $purchase['transportation_cost'];
        $createdPurchase = Purchase::create($purchase);
        $createdPurchase->items()->saveMany($stocks);

        return $purchase;
    }

    function generateInvoiceId(): string
    {
        $prefix = 'IZ7N';
        $randomPart1 = Str::random(4);
        $randomPart2 = Str::random(4);
        $randomPart3 = Str::random(4);

        return $prefix . '-' . $randomPart1 . '-' . $randomPart2 . '-' . $randomPart3;
    }

    protected function randomDate($lastYear=3): Carbon
    {
        $startDate = Carbon::now()->subYears($lastYear);
        $endDate = Carbon::now();
        return Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp));
    }
}
