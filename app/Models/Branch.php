<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table      = "branches";
    protected $primaryKey = "id";
    protected $fillable   = [
        "name",
        "address",
        "phone",
        "email",
        "is_active",
    ];
}
