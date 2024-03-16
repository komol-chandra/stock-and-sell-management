<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table      = "purchases";
    protected $primaryKey = "id";
    protected $fillable   = [
        "is_active",
        "is_deleted",
        "date",
        "invoice_id",
        "supplier_id",
        "transportation_cost",
        "grand_total",
        "note",
        "created_by",
        "updated_by",
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}
