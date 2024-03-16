<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table      = "products";
    protected $primaryKey = "id";
    protected $fillable   = [
        "is_active",
        "is_deleted",
        "name",
        "slug",
        "sku",
        "category_id",
        "brand_id",
        "unit_id",
        "image",
        "short_description",
        "description",
    ];

    public function scopeFullSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('sku', 'like', '%' . $search . '%');
        });
    }

    /**
     * @return HasMany
     */

    public function stock()
    {
        return $this->hasMany(Stock::class)
            ->select('product_id')
            ->selectRaw('SUM(purchase_qty - sell_qty) as available_qty')
            ->groupBy('product_id');
    }

    public function branchWishStock()
    {
        return $this->hasMany(Stock::class)
            ->where('branch_id', brunchId())
            ->select('product_id')
            ->selectRaw('SUM(purchase_qty - sell_qty) as available_qty')
            ->groupBy('product_id');
    }

    public function branchWishStockItem()
    {
        return $this->hasMany(Stock::class)
            ->where('branch_id', brunchId());
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
