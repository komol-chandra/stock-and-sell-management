<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table      = "orders";
    protected $primaryKey = "id";
    protected $fillable   = [
        "is_active",
        "is_deleted",
        "grand_total",
        "date",
        "invoice_id",
        "note",
        "customer_name",
        "customer_phone",
        "customer_id"
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
